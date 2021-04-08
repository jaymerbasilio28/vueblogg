<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $blogs = Blog::get();
            $status = 'success';
            $message = 'load Blogs';
        } catch (\Exeption $e){
            $blogs = [];
            $status = 'error';
            $message = $e->getMessage();
        }
        return response()-> json([
            'status' => $status,
            'message' => $message,
            'blogs' => $blogs
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            Blog::create($request->all());
            $status ='success';
            $message ='successfully saved blog';
        } catch(\Expectation $e){
            $status = 'error';
            $message = $e->getMessage();
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        try{
            $blog = Blog::find($id);
            $blog->update($request->all());
            $status ='success';
            $message ='successfully updated blog';
        } catch(\Expectation $e){
            $status = 'error';
            $message = $e->getMessage();
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $blog = Blog::find($id);
            $blog->delete();
            $status ='success';
            $message ='successfully deleted blog';
        } catch(\Expectation $e){
            $status = 'error';
            $message = $e->getMessage();
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
}
