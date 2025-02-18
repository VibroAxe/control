<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketProviderUpdateRequest;
use App\Models\TicketProvider;

class TicketProviderController extends Controller
{
    public function edit(TicketProvider $provider)
    {
        $config = $provider->configMapping();
        return view('admin.ticketproviders.edit', [
            'provider' => $provider,
            'config' => $config,
        ]);
    }

    public function update(TicketProviderUpdateRequest $request, TicketProvider $provider)
    {
        $provider->apikey = $request->input('apikey');
        $provider->webhook_secret = $request->input('webhook_secret');
        $provider->enabled = (bool)$request->input('enabled');
        $provider->save();
        return response()->redirectToRoute('admin.settings.index')->with('successMessage', "{$provider->name} has been updated");
    }

    public function clearcache(TicketProvider $provider)
    {
        $provider->clearCache();
        return response()->redirectToRoute('admin.settings.index')->with('successMessage', "{$provider->name} cache has been cleared");
    }
}
