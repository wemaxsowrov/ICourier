<?php
namespace App\Repositories\FrontWeb\SocialLink;

use App\Models\Backend\FrontWeb\SocialLink;
use App\Repositories\FrontWeb\SocialLink\SocialLinkInterface;

class SocialLinkRepository implements SocialLinkInterface{
    public function get(){
        return SocialLink::orderBy('position','asc')->paginate(10);
    }
    public function getAll(){
        return SocialLink::active()->orderBy('position','asc')->get();
    }
    public function getFind($id){
        return SocialLink::find($id);
    }
    public function store($request){
        try { 
            $socialLink           = new SocialLink();
            $socialLink->name     = $request->name;
            $socialLink->icon     = $request->icon;
            $socialLink->link     = $request->link;
            $socialLink->position = $request->position;
            $socialLink->status   = $request->status;
            $socialLink->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function update($id,$request){
        try {
            $socialLink           = $this->getFind($id);
            $socialLink->name     = $request->name;
            $socialLink->icon     = $request->icon;
            $socialLink->link     = $request->link;
            $socialLink->position = $request->position;
            $socialLink->status   = $request->status;
            $socialLink->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function delete($id){
        return SocialLink::destroy($id);
    }
}