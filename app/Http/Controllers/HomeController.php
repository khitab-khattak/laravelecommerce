<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class HomeController extends Controller
{
   public function index()
    {
        $slides = Slide::where('status',1)->get()->take(3);
        //show categories
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price',"<>",'')->inRandomOrder()->get()->take(8);
        $fproducts = Product::where('featured',1)->get()->take(8);
        return view('index',compact('slides','categories','sproducts','fproducts'));
    }
    
    public function contact(){
        return view('contact');
    }
    public Function contact_store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email',
            'phone'=>'required|numeric|digits:11',
            'comment'=>'required|string'
        ]);
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('success','Your message has been sent successfully');
    }
    public function contacts(){
        $contacts = Contact::orderBy('created_at','DESC')->paginate(10);
        return view('admin.contacts',compact('contacts'));
    }

    public function destroy($id){
        $contacts = Contact::find($id);
        $contacts->delete();
        return redirect()->back()->with('success','Message has been Deleted Successfully!');

    }
}
