<?php
namespace App\Repositories\FrontWeb\Faq;

use App\Models\Backend\FrontWeb\Faq;
use App\Repositories\FrontWeb\Faq\FaqInterface;
class FaqRepository implements FaqInterface{
    
    public function get(){
        return Faq::orderBy('position','asc')->paginate(10);
    }
    public function getActive(){
        return Faq::active()->orderBy('position','asc')->paginate(10);
    }
    public function getFind($id){
        return Faq::find($id);
    }
    public function store($request){
        try {  
            $faq              = new Faq(); 
            $faq->question     = $request->question; 
            $faq->answer      = $request->answer;
            $faq->position    = $request->position;
            $faq->status      = $request->status;
            $faq->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function update($id,$request){
        try {
            $faq              = $this->getFind($id);
            $faq->question    = $request->question; 
            $faq->answer      = $request->answer;
            $faq->position    = $request->position;
            $faq->status      = $request->status;
            $faq->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function delete($id){
        return Faq::destroy($id);
    }
 
}