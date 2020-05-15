<?php
/**
 * Created by PhpStorm.
 * User: linlin
 * Date: 2019-08-27
 * Time: 13:48
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller{



    /**
     * @Desc: 切片上传
     *
     * @param Request $request
     * @return mixed
     */

    public function sliceUpload(Request $request)
    {

        try{
            $file = $request->file('file');// 接收一个切片，是一个文件，所以用$_FILES接收
            $blob_num = $request->get('blob_num');//编号
            $total_blob_num = $request->get('total_blob_num');//总数
            $file_name = $request->get('file_name');// 文件的原始文件名
            $realPath = $file->getRealPath(); //临时文件的绝对路径
            // 存储地址
            $path = 'slice/'.date('Ymd')  ;
            $filename = $path .'/'. $file_name . '_' . $blob_num;

            //上传
            $upload = Storage::disk('local')->put($filename, file_get_contents($realPath));

            //判断是否是最后一块，如果是则进行文件合成并且删除文件块
            if($blob_num == $total_blob_num){
                for($i=1; $i<= $total_blob_num; $i++){
                    $blob = Storage::disk('local')->get($path.'/'. $file_name.'_'.$i);
//              Storage::disk('admin')->append($path.'/'.$file_name, $blob);   //不能用这个方法，函数会往已经存在的文件里添加0X0A，也就是\n换行符
                    file_put_contents(storage_path('/app/public/uploads').'/'.$path.'/'.$file_name,$blob,FILE_APPEND);
                }
                //合并完删除文件块
                for($i=1; $i<= $total_blob_num; $i++){
                    Storage::disk('local')->delete($path.'/'. $file_name.'_'.$i);
                }
            }

            if ($upload){
                $y_m=date('Ym');

                $thumbImg='video_thumb/'.$y_m.'/'.$file_name;
                $file_path=storage_path('app/public/uploads').'/'.$path.'/'.$file_name;
                echo '<pre>';
                print_r($file_path);
                exit;
                return 'success';
            }else{
                return  'fail';
            }
        }catch (\Exception $e){
            echo $e->getMessage();exit;
        }



    }
}