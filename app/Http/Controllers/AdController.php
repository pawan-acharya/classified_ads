<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JoggApp\GoogleTranslate\GoogleTranslateClient;
use Illuminate\Support\Collection;
use Auth;
use DB;
use Lang;
use App\Ad;
use App\File;
use App\Lease;

class AdController extends Controller
{

    public function index(Request $request)
    {

        define('PER_PAGE', 9);
        $query = DB::table('ads')
        ->select('ads.*')
        ->addSelect('leases.monthly_payments_before_taxes', 
            'leases.contract_kilometers', 
            'leases.initial_down_payment',  
            'leases.incentive_amount', 
            'leases.contract_duration',
            DB::raw('leases.monthly_payments_before_taxes + (leases.initial_down_payment/leases.contract_duration) AS payment'),
            DB::raw('(leases.contract_kilometers - ads.current_mileage ) / leases.contract_duration AS remaining_monthly_kms')
        )->leftjoin('leases', 'leases.id', '=', 'ads.lease_id')
        ->leftjoin('users', 'users.id', '=', 'ads.user_id')
        ->where('ads.plan_id', '!=', null)
        ->orderBy($request->query('sort_by')?:'created_at', $request->query('order')?:'desc');

        if($request->query('category')) {
            $query->where('category', $request->query('category'));
        }

         if($request->query('brand')) {
            $query->where('brand', $request->query('brand'));
        }

        if($request->query('model')) {
            $query->where('model', $request->query('model'));
        }

        if($request->query('from_vehicle_year')) {
            $query->where('vehicle_year', '>=', $request->query('from_vehicle_year'));
        }

        if($request->query('to_vehicle_year')) {
            $query->where('vehicle_year', '<=', $request->query('to_vehicle_year'));
        }

        if($request->query('from_contract_duration')) {
            $query->where('contract_duration', '>=', $request->query('from_contract_duration'));
        }

        if($request->query('to_contract_duration')) {
            $query->where('contract_duration', '<=', $request->query('to_contract_duration'));
        }

        if($request->query('from_remaining_monthly_kms')) {
            $query->where('remaining_monthly_kms', '>=', $request->query('from_remaining_monthly_kms'));
        }

        if($request->query('to_remaining_monthly_kms')) {
            $query->where('remaining_monthly_kms', '<=', $request->query('to_remaining_monthly_kms'));
        }
       
        $ads = $query->get();

        $adCollection = [];
        foreach($ads as $ad) {
            array_push($adCollection, Ad::find($ad->id));
        }

        $ads = (new Collection($adCollection));

        $fromPayment = $request->query('from_payment') ?: 0;
        $toPayment = $request->query('to_payment') ?: 10000;
        $filtered = $ads->filter(function ($ad) use ($fromPayment, $toPayment){
            if($ad->payment > $fromPayment && $ad->payment < $toPayment) {
                return $ad;
            }
        });
        $ads = $filtered;

        $ads = $ads->paginate(PER_PAGE);

     
        $payment_options = collect(range(1, 20))->mapWithKeys(function ($item) {
            $amount = $item*50;
            return [$amount => $amount];
        });

        $vehicle_year_options = collect(range(0, 30))->mapWithKeys(function ($item) {
            $year = (string) date('Y') - $item;
            return [$year => $year];
        });
        
        $contract_duration_options = collect(range(1, 30))->mapWithKeys(function ($item) {
            $month = $item . ' '.Lang::get('ads.month');
            return [$item => $month];
        });

        $remaining_monthly_kms = collect(range(1, 10))->mapWithKeys(function ($item) {
            $km_month = $item*500;
            return [$km_month => $km_month];
        });
            
        return view('ads.index', compact(
            'ads', 
            'vehicle_year_options', 
            'contract_duration_options', 
            'remaining_monthly_kms',
            'payment_options'
            )
        );
    }
   
    public function create(Request $request)
    {
        return view('ads.create');
    }

    public function next(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($request->has('interior_options')) {
            $data['interior_options'] = join(',', $data['interior_options']); 
        }
        if ($request->has('inclusion_options')) {
            $data['inclusion_options'] = join(',', $data['inclusion_options']); 
        }

        $tr = new GoogleTranslateClient(config('googletranslate'));
        $translationFields = $request->input('exterior_color')?:$request->input('interior_color');
        if($translationFields) {
            $lang = $tr->detectLanguage($translationFields);
            if($request->input('exterior_color')) {
                if($lang['languageCode'] == 'fr') {
                    $translated = $tr->translate($request->input('exterior_color'), 'en');
                    $data['exterior_color'] = $translated['text'];
                    $data['exterior_color_fr'] = $request->input('exterior_color');
                } else {
                    $translated = $tr->translate($request->input('exterior_color'), 'fr');
                    $data['exterior_color_fr'] = $translated['text'];
                }
            }
            if($request->input('interior_color')) {
                if($lang['languageCode'] == 'fr') {
                    $translated = $tr->translate($request->input('interior_color'), 'en');
                    $data['interior_color'] = $translated['text'];
                    $data['interior_color_fr'] = $request->input('interior_color');
                } else {
                    $translated = $tr->translate($request->input('interior_color'), 'fr');
                    $data['interior_color_fr'] = $translated['text'];
                }
            }
        }
    
        //create ad
        $ad = new Ad;
        $ad->fill($data);

        //Add images to ad
        if ($request->has('images')) {
            foreach($request->file('images') as $image) {
                $request->session()->push('images', $ad->upload($image));
            }
        }
        $request->session()->put('ad', $ad);
        return redirect()->back()->withInput();
    }

    public function nextUpdate(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($request->has('interior_options')) {
            $data['interior_options'] = join(',', $data['interior_options']); 
        }
        if ($request->has('inclusion_options')) {
            $data['inclusion_options'] = join(',', $data['inclusion_options']); 
        }

        $tr = new GoogleTranslateClient(config('googletranslate'));
        $translationFields = $request->input('exterior_color')?:$request->input('interior_color');
        if($translationFields) {
            $lang = $tr->detectLanguage($translationFields);
            if($request->input('exterior_color')) {
                if($lang['languageCode'] == 'fr') {
                    $translated = $tr->translate($request->input('exterior_color'), 'en');
                    $data['exterior_color'] = $translated['text'];
                    $data['exterior_color_fr'] = $request->input('exterior_color');
                } else {
                    $translated = $tr->translate($request->input('exterior_color'), 'fr');
                    $data['exterior_color_fr'] = $translated['text'];
                }
            }
            if($request->input('interior_color')) {
                if($lang['languageCode'] == 'fr') {
                    $translated = $tr->translate($request->input('interior_color'), 'en');
                    $data['interior_color'] = $translated['text'];
                    $data['interior_color_fr'] = $request->input('interior_color');
                } else {
                    $translated = $tr->translate($request->input('interior_color'), 'fr');
                    $data['interior_color_fr'] = $translated['text'];
                }
            }
        }
    
        //Update ad data
        $ad = Ad::findOrFail($id);
        $ad->fill($data);

        //Add images to ad if any uploaded
        if ($request->has('images')) {
            foreach($request->file('images') as $image) {
                $request->session()->push('images-edit', $ad->upload($image));
            }
        }
        $request->session()->put('ad-edit', $ad);
        return redirect()->back()->withInput();
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $ad = $request->session()->get('ad');

            //Get title and description in other language
            $tr = new GoogleTranslateClient(config('googletranslate'));
            $lang = $tr->detectLanguage($request->input('title'));
             if($lang['languageCode'] == 'fr') {
                $translated = $tr->translateBatch([$request->input('title'), $request->input('description')], 'en');
                if($translated){
                    $ad->fill([
                        'title' => $translated[0]['text'],
                        'description' => $request->input('description')?$translated[1]['text']:'',
                        'title_fr' => $request->input('title'),
                        'description_fr' => $request->input('description')
    
                    ]);
                } else {
                    $ad->fill([
                        'title' => $request->input('title'),
                        'description' => $request->input('description')?:'',
                        'title_fr' => $request->input('title'),
                        'description_fr' => $request->input('description')
    
                    ]);
                }

               
            } else {
                $translated = $tr->translateBatch([$request->input('title'), $request->input('description')], 'fr');
                if($translated){
                    $ad->fill([
                        'title' => $request->input('title'),
                        'description' => $request->input('description')?:'',
                        'title_fr' => $translated[0]['text'],
                        'description_fr' => $request->input('description')?$translated[1]['text']:'',
                    ]);
                } else {
                    $ad->fill([
                        'title' => $request->input('title'),
                        'description' =>  $request->input('description')?:'',
                        'title_fr' => $request->input('title'),
                        'description_fr' =>  $request->input('description')?:'',

                    ]);
                }
            }

            //Add lease to ad
            $lease = Lease::create($data);
            $ad->lease()->associate($lease);

            $ad->save();

            if ($request->session()->has('images')) {
                foreach($request->session()->get('images') as $image) {
                    $ad->file()->create($image);
                }
            }

            $request->session()->forget('ad');
            $request->session()->forget('images');

            return redirect()->route('ads.review',$ad->id)->with('status', Lang::get('ads.successful'));

        } catch (\Exception $e) {
            throw $e;
            //return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function review($id)
    {
        $ad = Ad::with(['files','lease','user'])->find($id);

        return view('ads.review', compact('ad'));
    }

    public function show($id)
    {
        $ad = Ad::with(['files','lease','user'])->find($id);

        return view('ads.show', compact('ad'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $ad = $request->session()->get('ad-edit');

            //Get title and description in other language
            $tr = new GoogleTranslateClient(config('googletranslate'));
            $lang = $tr->detectLanguage($request->input('title'));
            if($lang['languageCode'] == 'en') {
                $translated = $tr->translateBatch([$request->input('title'), $request->input('description')], 'fr');
                $data['title'] = $request->input('title');
                $data['description'] = $request->input('description');
                $data['title_fr'] =  $translated[0]['text'];
                $data['description_fr'] = $request->input('description')?$translated[1]['text']:'';
            }  elseif($lang['languageCode'] == 'fr') {
                $translated = $tr->translateBatch([$request->input('title'), $request->input('description')], 'en');
                $data['title'] = $translated[0]['text'];
                $data['description'] =  $request->input('description')?$translated[1]['text']:'';
                $data['title_fr'] =  $request->input('title');
                $data['description_fr'] = $request->input('description');
            }

            $lease = Lease::findOrFail($ad->lease->id);
            if ($request->session()->has('images-edit')) {
                foreach($request->session()->get('images-edit') as $image) {
                    $ad->file()->create($image);
                }
            }
            $lease = $lease->update($data);
            $ad = $ad->update($data);

            $request->session()->forget('ad-edit');
            $request->session()->forget('images-edit');
            return redirect()->route('ads.show', $id);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {

        $ad = Ad::findOrFail($id);
        if(Auth::user()->id !== $ad->user->id) {
            return abort(403);
        }
      
        return view('ads.edit', compact('ad'));
    }

    public function deleteFile(Request $request, $id) {

        File::findOrFail($id)->delete();
        return response()->json(['success' => 'true']);

    }

}
