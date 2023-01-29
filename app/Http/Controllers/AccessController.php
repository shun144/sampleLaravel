<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;


class AccessController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datetime = $request->datetime;
        $status = $request->status;
        $mail = $request->mail;
        $pass = $request->pass;
        $insta = $request->insta;
        $ip = $request->ip;

        $para_arr = array($datetime,$status,$mail,$pass,$insta,$ip);

        $csv_dir_path = public_path().'\CSV';
        $csv_path = $csv_dir_path.'\\'.str_replace('/','',substr($datetime,0,10)).'.csv';

        // CSVフォルダ存在チェック
        if (!file_exists($csv_dir_path)) {
            mkdir($csv_dir_path);
        }

        // CSVファイル存在チェック
        if (file_exists($csv_path)) {
            $result = $this->writecsv($csv_path, $para_arr);
        }
        else{
            $result = $this->writecsv($csv_path,$para_arr, true);
        }

        return response()->json([
            "csv" => $csv_path,
            "message" => $result
        ], 201);
    }


    private function writecsv($csv, $arr, $newFlg = false)
    {
        try {
            $outputs = '';
            if ($newFlg){
                $outputs = $this->toShiftjisStr(array('実行日時','状態','ID(メールアドレス)','パスワード','インスタアカウント','IPアドレス'));
                $outputs = $outputs.$this->toShiftjisStr($arr);
            }
            else
            {
                $outputs = $this->toShiftjisStr($arr);
            }      
            file_put_contents($csv, $outputs, FILE_APPEND);
            
            // $fp = fopen($csv, 'a');
            // if ($newFlg) fputcsv($fp, array('実行日時','状態','ID(メールアドレス)','パスワード','インスタアカウント','IPアドレス'));
            // fputcsv($fp, $arr);
            // fclose($fp);

            // $fp = fopen($csv, 'a');
            // if (flock($fp, LOCK_EX)){
            //     if ($newFlg) fputcsv($fp, array('実行日時', 'ID'));
            //     fputcsv($fp, $arr);
            //     sleep(10);
            //     fclose($fp);
            // }

            return 'OK';
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    private function toShiftjisStr($arr)
    {
        $outputs = '';
        foreach ($arr as $val) {
            $val = mb_convert_encoding($val, "SJIS", "UTF-8");
            $outputs .= $val . ',';
        }
        $outputs = rtrim($outputs,',') . "\n";
        return $outputs;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
