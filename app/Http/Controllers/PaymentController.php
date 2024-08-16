<?php

namespace App\Http\Controllers;
use Explicador\E2PaymentsPhpSdk\Mpesa;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function handlePayment(Request $request) {
        // Set the consumer key and consumer secret as follows
        $mpesa = new Mpesa();
        $mpesa->setClientId('9610234b-9e7e-4935-9557-c6770e7b0c72');
        $mpesa->setClientSecret('sBNnN5aa3VjZ38koBkJnIgSkMtoV3vyrO6hIkd8V');
        $mpesa->setWalletId('728381');// 'live' production environment 

        //This creates transaction between an M-Pesa short code to a phone number registered on M-Pesa.
        $phone_number = '844503505';
        $amount = 670;
        $reference = 'iMac';
        $result = $mpesa->c2b($phone_number, $amount, $reference);

        dd($result);
    }

    public function store(Request $request)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|max:255',
            'address' => 'string',
            'tel' => 'required|string|max:20',
            'amount' => 'required',
            'reference' => 'required',
        ]);

        try {
            // Configuração do cliente Mpesa com variáveis de ambiente
            $mpesa = new Mpesa();
            $mpesa->setClientId(env('CLIENTID'));
            $mpesa->setClientSecret(env('SECRETKEY'));
            $mpesa->setWalletId(env('WALLETID'));

            // Execução da transação
            $result = $mpesa->c2b($validatedData['tel'], $validatedData['amount'], $validatedData['reference']);

            // Verificando se a transação foi bem-sucedida
            if ($result && $result->status === 'success') {
                // Redireciona com mensagem de sucesso
                return redirect()->back()->with('success', 'Pagamento efectuado com sucesso');
            } else {
                // Lida com falha na transação (por exemplo, se $result->status não for 'success')
                return redirect()->back()->with('error', 'Falha ao processar o pagamento. Por favor, tente novamente.');
            }
        } catch (\Exception $e) {
            // Captura qualquer exceção e redireciona com uma mensagem de erro
            return redirect()->back()->with('error', 'Ocorreu um erro: ' . $e->getMessage());
        }
    }

}
