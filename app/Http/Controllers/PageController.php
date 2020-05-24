<?php

namespace App\Http\Controllers;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use Hash;
use App\BillStatus;
//use Auth;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
    	//return view('page.trangchu',['slide'=>$slide]);
        $new_product = Product::where('new',1)->orderBy('created_at','desc')->paginate(8);
        $sanpham = Product::where('id','!=',null)->orderBy('created_at','desc')->paginate(12);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->orderBy('created_at','desc')->paginate(8);
        return view('page.trangchu',compact('slide','new_product','sanpham','sanpham_khuyenmai'));
    }

    public function getAll(){
        $slide = Slide::all();
        $allsanpham = Product::all();
        return view('page.danhsach_sanpham',compact('slide','allsanpham'));
    }

    public function getSearch(Request $req){
        $slide = Slide::all();
        $timkiemsanpham = Product::query()->where('name', 'LIKE', "%{$req->s}%")->get();
        return view('page.timkiem_sanpham',compact('slide','timkiemsanpham'));
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id',$type)->first();
    	return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }

    public function getChitiet(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
    	return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

    public function getLienHe(){
    	return view('page.lienhe');
    }

    public function getGioiThieu(){
    	return view('page.gioithieu');
    }

    public function getAddtoCart(Request $req,$id){
        if ($req->has('sl')) {
            for ($i = 0; $i < $req->sl; $i++){
                $product = Product::find($id);
                $oldCart = Session('cart')?Session::get('cart'):null;
                $cart = new Cart($oldCart);
                $cart->add($product, $id);
                $req->session()->put('cart',$cart);
            }
            return redirect()->back();
        }else{
            $product = Product::find($id);
            $oldCart = Session('cart')?Session::get('cart'):null;
            $cart = new Cart($oldCart);
            $cart->add($product, $id);
            $req->session()->put('cart',$cart);
            return redirect()->back();
        }
    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function getCheckout(){
        return view('page.dat_hang');
    }

    public function postCheckout(Request $req){
        $cart = Session::get('cart');

        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->status_id = 0;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công');

    }

    public function getLogin(){
//        dd(Auth::check());
        if(Auth::check()){
            return redirect('/');
        }
        return view('page.dangnhap');
    }
    public function getSignin(){
        return view('page.dangki');
    }

    public function postSignin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự',
                'password.max'=>'Mật khẩu không quá 20 kí tự'
            ]);
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công');
    }

    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự',
                'password.max'=>'Mật khẩu không quá 20 kí tự'
            ]);
        $credentials = array('email'=>$req->email,'password'=>$req->password);
//        dd(Hash::make($req->password));
        $user = User::where([
                ['email','=',$req->email],
            ])->first();

        if($user){
            if(Auth::attempt($credentials)){
                if($user->is_admin){
                    return redirect()->intended('defaultpage');
                }
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
            }
        }
        else{
           return redirect()->back()->with(['flag'=>'danger','message'=>'Tài khoản không tồn tại']);
        }
        
    }
    public function postLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function Add(){
        $product_type = ProductType::all();
        return view('admin.add-product', compact('product_type'));
    }

    public function addProduct(Request $request){
        $product = new Product;
        $product->name = $request->name;
        $product->id_type = $request->type;
        $product->description = $request->desc;
        $product->unit_price = $request->price;
        $product->promotion_price = $request->promotion;
        $product->unit = $request->unit;
        $product->new = $request->new=='on'?1:0;
        //img
        if ($request->hasFile('img')) {
            $file = $request->img;
            $file->move('source/image/product', $file->getClientOriginalName());
            $product->image = $file->getClientOriginalName();
        }
        $product->save();

        return redirect()->back()->with('thongbao','Thêm sản phẩm thành công');
    }

    public function listProduct(){
        $product = Product::all();
        return view('admin.list-product', compact('product'));
    }

    public function editProduct(Request $request, $id = null){
        if($request->isMethod('get')){
            $product = Product::find($id);
            $product_type = ProductType::all();
            return view('admin.edit-product',compact('product','product_type'));
        }else{
            //update product
            $product = Product::find($id);

            $product->name = $request->name;
            $product->id_type = $request->type;
            $product->description = $request->desc;
            $product->unit_price = $request->price;
            $product->promotion_price = $request->promotion;
            $product->unit = $request->unit;
            $product->new = $request->new=='on'?1:0;
            if($request->hasFile('img')){
                $file = $request->img;
                if ($product->image != $file->getClientOriginalName()) {
                    $file->move('source/image/product', $file->getClientOriginalName());
                    $product->image = $file->getClientOriginalName();
                }
            }

            $product->save();
            return redirect()->back()->with('thongbao','Cập nhật sản phẩm thành công');
        }
    }
    public function removeProduct($id){
        Product::destroy($id);
        return redirect()->back()->with('thongbao','Xóa sản phẩm thành công');
    }

    public function listBill(){
        $bills = Bill::all();
        $customers = array();
        $bill_status = array();
        foreach($bills as $bill){
            $customer_name = Customer::find($bill->id_customer)->name;
            $customers[$bill->id] = $customer_name;

            $bill_status_name = BillStatus::find($bill->status_id)->name;
            $bill_status[$bill->status_id] = $bill_status_name;
        }
//        dd($customers);
        return view('admin.list-bills',compact('bills','customers','bill_status'));
    }

    public function editBill(Request $request, $id = null){
        if($request->isMethod('get')){
            $bill = Bill::find($id);
            $customers = array();
            $customer_name = Customer::find($bill->id_customer)->name;
            $customers[$bill->id] = $customer_name;

            $bill_status = array();
            $bill_status_name = BillStatus::find($bill->status_id)->name;
            $bill_status[$bill->status_id] = $bill_status_name;

            return view('admin.edit-bills',compact('bill','customers','bill_status'));
        }else{
            //update product
            $bill = Bill::find($id);
            $bill->status_id = $request->status;
            $bill->save();
            return redirect()->back()->with('thongbao','Cập nhật bill thành công');
        }
    }

    public function removeBill($id){
        $bill = Bill::find($id);
        Customer::destroy($bill->id_customer);
        Bill::destroy($id);
        $bill_details = BillDetail::all();
        foreach($bill_details as $bill_detail){
            if ($bill_detail->id_bill == $id){
                BillDetail::destroy($bill_detail->id);
            }
        }
        return redirect()->back()->with('thongbao','Xóa bill thành công');
    }

    public function addType(Request $request){
        $producttype = new ProductType;
        $producttype->name = $request->name;
        $producttype->description = $request->desc;
        //img
        if ($request->hasFile('img')){
            $file = $request->img;
            $file->move('source/image/product', $file->getClientOriginalName());
            $producttype->image = $file->getClientOriginalName();
        }
        $producttype->save();

        return redirect()->back()->with('thongbao','Thêm loại thành công');
    }
}
