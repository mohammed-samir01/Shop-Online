<?php

    namespace App\Http\traits;

    trait generalTrait{
        public function uploadPhoto($photo,$folder)
        {
            $fileName  = time().'.'.$photo->extension();
            $photo->move(public_path('uploads/'.$folder),$fileName);
            return $fileName;
        }
    }

?>