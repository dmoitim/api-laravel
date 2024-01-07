<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceResourceCollection;
use App\Models\Invoice;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return (new Invoice())->filter($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . implode(',', ['B', 'C', 'P']),
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
            'value' => 'required|numeric|between:0.01,9999.99'
        ]);

        if ($validator->fails()) {
            return $this->error('Ocorreu um erro ao tentar processar a inclusão.', 422, $validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if (!$created) {
            return $this->error('Invoice não cadastrado. Ocorreu um erro ao tentar gravar no banco de dados.', 400);
        }

        return $this->success('Invoice cadastrado com sucesso.', 201, new InvoiceResource($created->load('user')));
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . implode(',', ['B', 'C', 'P']),
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
            'value' => 'required|numeric|between:0.01,9999.99'
        ]);

        if ($validator->fails()) {
            return $this->error('Ocorreu um erro ao tentar processar a alteração.', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'paid' => $validated['paid'],
            'payment_date' => $validated['paid'] ? $validated['payment_date'] : NULL,
            'value' => $validated['value']
        ]);

        if (!$updated) {
            return $this->error('Invoice não atualizado. Ocorreu um erro ao tentar gravar no banco de dados.', 400);
        }

        return $this->success('Invoice atualizado com sucesso.', 200, new InvoiceResource($invoice->load('user')));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $deleted = $invoice->delete();

        if (!$deleted) {
            return $this->error('Invoice não excluído. Ocorreu um erro ao tentar gravar no banco de dados.', 400);
        }

        return $this->success('Invoice excluído com sucesso.', 200);
    }
}
