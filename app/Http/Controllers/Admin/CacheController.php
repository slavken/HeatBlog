<?php

namespace App\Http\Controllers\Admin;

use App\CacheModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    function __construct()
    {
        $this->middleware('can:cache');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cache = CacheModel::all();

        return view('home.admin.cache.index', ['cache' => $cache]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.admin.cache.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:cache'
        ]);

        $cache = new CacheModel();

        $cache->name = $request->name;

        $cache->save();

        return redirect()
            ->route('cache.index')
            ->with('status', 'The cache key added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cache = CacheModel::findOrFail($id);
        $cache->delete();

        return redirect()
            ->route('cache.index');
    }

    public function clear($key = null)
    {
        if ($key) {
            if (!Cache::has($key)) return back();

            Cache::forget($key);

            return redirect()
                ->route('cache.index')
                ->with('status', 'Cache is cleared! [' . $key . ']');
        }

        Cache::flush();

        return redirect()
            ->route('cache.index')
            ->with('status', 'Cache is cleared!');
    }
}
