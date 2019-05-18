<?php

namespace App\Http\Controllers;

use App\Models\Items\Fault\ItemFault;
use App\Models\Items\ItemInstance;
use App\Models\Items\ItemType;
use App\Models\Location;
use App\Models\Reservations\Reservation;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $query
     * @return void
     */
    public function __invoke(Request $request)
    {
        $query = $request->get('query', '');

        if (empty($query)) {
            return redirect()->to('');
        }

        if (preg_match('/([a-zA-Z\/]+)(\d+)/', $query, $matches)) {
            $key = strtoupper($matches[1]);
            $id = intval($matches[2], 10);

            $prefix = route('home');

            $component = null;

            if ($key === 'F') {
                $fault = ItemFault::find($id);

                if ($fault) {
                    $component = 'instances/' . $fault->item->id . '/fault';
                }
            } else {
                $keys = [
                    'I' => 'instances',
                    'T' => 'types',
                    'L' => 'locations',
                    'R' => 'reservations',
                ];

                if (array_key_exists($key, $keys)) {
                    $component = $keys[$key];
                }
            }

            if ($component) {
                $url = $prefix . '/' . $component . '/' . $id;
                return redirect($url);
            }
        }

        $searchResults = (new Search())
            ->registerModel(ItemInstance::class, 'label')
            ->registerModel(ItemType::class, 'concat(manufacturer, \' \', model)')
            ->registerModel(Location::class, 'name')
            ->registerModel(ItemFault::class, 'name', 'description')
            ->search($query);

        return view('search.view', ['results' => $searchResults, 'query' => $query]);
    }
}
