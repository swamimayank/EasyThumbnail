# EasyThumbnail-
Create  Thumbnail using php image gd library 

Call easy_thumbnail function and pass following parameter 


     @param $original_file_path
     @param $new_width
     @param $new_height
     @param string $save_path
     @param string $log   
     @return bool|string  
 
 @param string $log  // By default log is false but can be enabled by passing param to true
 @return bool|string  // It return thumbnail path on success and false if thumbnail not crated and  generate log

rest of them are self explanatory.

ie.
   
      function easy_thumbnail($original_file_path, $new_width, $new_height, $save_path = "", $log = "FALSE")


