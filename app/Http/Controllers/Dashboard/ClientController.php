<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    
    public function index(Request $request)
    {
        $clients = Client::When($request->search, function($q) use ($request)
        {
            return $q->where('name', 'like', '%' . $request->search . '%')

                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    
                    ->orWhere('address', 'like', '%' . $request->search . '%');
                    
        })->latest()->paginate(5);

            return view('dashboard.clients.index', compact('clients'));
    }

    
    public function create()
    {
        return view('dashboard.clients.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',

        ]);

        $request_data = $request->all();
        $request_data['phone'] = array_filter($request->phone);

        
        Client::create($request->all());

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }



    public function edit($id)
    {
        $client = Client::find($id);

        return view('dashboard.clients.edit', compact('client'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',

        ]);

        $request_data = $request->all();
        $request_data['phone'] = array_filter($request->phone);

        $client = Client::find($id);
        $client->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');        
    }
}
