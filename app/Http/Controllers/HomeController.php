<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Category, Contact, Product, Slide};

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status',1)->get()->take(5);
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price','<>','')->inRandomOrder()->get()->take(5);
        $fproducts = Product::where('featured',1)->get()->take(15);

        return view('index',compact('slides','fproducts','sproducts','categories'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();

        return redirect('/');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $contact = New Contact();
        $contact->name     = $request->name;
        $contact->email    = $request->email;
        $contact->phone    = $request->phone;
        $contact->comment  = $request->comment;

        $contact->save();
        return redirect()->back()->with('status','Message sent successfully');
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        $products = Product::where('name', 'LIKE', "%$query%")
                            ->select('id','name','slug','image')
                            ->get();

        return response()->json($products);
    }
}
