<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $contacts = $user->contacts;

            return response()->json(['contacts' => $contacts]);
        } else {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $contact = $user->contacts()->create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'telephone' => $request->input('telephone'),
                'category' => $request->input('category')
            ]);

            return response()->json(['message' => 'Contact created successfully', 'contact' => $contact]);
        } else {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $contact = $user->contacts()->find($id);
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }
        return response()->json(['contact' => $contact]);
    }

    public function update(Request $request, $id)
    {

        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        if ($contact->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $contact->update($request->all());

        return response()->json(['message' => 'Contact updated successfully', 'contact' => $contact]);
    }

    public function destroy($id)
    {

        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        if ($contact->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }

    public function mapearDDDParaLocalizacao($ddd)
    {
        $mapeamento = [
            'Centro-Oeste' => [
                'Distrito Federal' => ['61'],
                'Goiás' => ['62', '64'],
                'Mato Grosso' => ['65', '66'],
                'Mato Grosso do Sul' => ['67'],
            ],
            'Nordeste' => [
                'Alagoas' => ['82'],
                'Bahia' => ['71', '73', '74', '75', '77'],
                'Ceará' => ['85', '88'],
                'Maranhão' => ['98', '99'],
                'Paraíba' => ['83'],
                'Pernambuco' => ['81', '87'],
                'Piauí' => ['86', '89'],
                'Rio Grande do Norte' => ['84'],
                'Sergipe' => ['79'],
            ],
            'Norte' => [
                'Acre' => ['68'],
                'Amapá' => ['96'],
                'Amazonas' => ['92', '97'],
                'Pará' => ['91', '93', '94'],
                'Rondônia' => ['69'],
                'Roraima' => ['95'],
                'Tocantins' => ['63'],
            ],
            'Sudeste' => [
                'Espírito Santo' => ['27', '28'],
                'Minas Gerais' => ['31', '32', '33', '34', '35', '37', '38'],
                'Rio de Janeiro' => ['21', '22', '24'],
                'São Paulo' => ['11', '12', '13', '14', '15', '16', '17', '18', '19'],
            ],
            'Sul' => [
                'Paraná' => ['41', '42', '43', '44', '45', '46'],
                'Rio Grande do Sul' => ['51', '53', '54', '55'],
                'Santa Catarina' => ['47', '48', '49'],
            ],
        ];

        foreach ($mapeamento as $regiao => $estados) {
            foreach ($estados as $estado => $ddds) {
                if (in_array($ddd, $ddds)) {
                    return "$estado - $regiao";
                }
            }
        }

        return 'Localização não encontrada';
    }

    public function relatorioEstatistico()
    {
        $user = Auth::user();

        $now = now();
        $dozeHorasAtras = $now->subHours(12);

        $totalContatos = Contact::where('user_id', $user->id)->count();

        $ultimoContatoAdd = Contact::where('user_id', $user->id)->orderBy('created_at', 'desc')->first()->created_at;
        if ($ultimoContatoAdd->lt($dozeHorasAtras)) {
            $totalContatosUltimas12Horas = 0;
        } else {
            $totalContatosUltimas12Horas = Contact::where('user_id', $user->id)->where('created_at', '>=', $dozeHorasAtras)->count();
        }


        $contatosPorMes = Contact::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as contacts'))
            ->where('user_id', $user->id)
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($item) {
                $monthNumber = $item->month;
                $monthName = Carbon::create()->month($monthNumber)->locale('pt_BR')->monthName;
                $item->month = $monthName;
                return $item;
            });


        if ($totalContatos > 0) {
            $localizacoes = Contact::where('user_id', $user->id)
                ->select(DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(telephone, ")", 1), "(", -1) as ddd'), DB::raw('COUNT(*) as count'))
                ->groupBy('ddd')
                ->get();
        }

        $regioes = [];
        foreach ($localizacoes as $localizacao) {
            $localizacao->localizacao = $this->mapearDDDParaLocalizacao($localizacao->ddd);
            $regiao = explode(' - ', $localizacao->localizacao)[1];
            if (!isset($regioes[$regiao])) {
                $regioes[$regiao] = 0;
            }
            $regioes[$regiao] += $localizacao->count;
        }

        return response()->json([
            'totalContatos' => $totalContatos,
            'totalContatosUltimas12Horas' => $totalContatosUltimas12Horas,
            'localizacoes' => $localizacoes,
            'contatosPorMes' => $contatosPorMes,
            'regioes' => $regioes,
        ]);
    }
}
