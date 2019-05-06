<?php

namespace App\Http\Controllers;

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

            switch ($key) {
                case 'I':
                    $item = ItemInstance::find($id);

                    if ($item) {
                        return redirect()
                            ->route('instances.view', $item);
                    }

                    break;
                case 'T':
                    $type = ItemType::find($id);

                    if ($type) {
                        return redirect()
                            ->route('types.view', $type);
                    }

                    break;
                case 'L':
                    $location = Location::find($id);

                    if ($location) {
                        return redirect()
                            ->route('locations.view', $location);
                    }

                    break;
                case 'R':
                    $reservation = Reservation::find($id);

                    if ($reservation) {
                        return redirect()
                            ->route('reservations.view', $reservation);
                    }

                    break;
            }
        }

        $searchResults = (new Search())
            ->registerModel(ItemInstance::class, 'label')
            ->registerModel(ItemType::class, 'concat(manufacturer, \' \', model)')
            ->registerModel(Location::class, 'name')
            ->search($query);

        return view('search.view', ['results' => $searchResults, 'query' => $query]);
    }
}
