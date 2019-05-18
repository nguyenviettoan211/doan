<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Partner;
use App\Reservation;
use App\Facility;
use App\User;

class PartnerController extends Controller
{
    public function index()
    {
        // Displays the Partners List for the Admin.
        $Partners = Partner::all();
        return view('adminM.ListPartner', compact('Partners'));
    }
    //Downgrades A partner which has been selected by Admin to a normal User.
    public function remove(Partner $partner, User $user)
    {
        $Id = $partner->id;
        $SelectedPartner = $partner->find($Id);
        $UID = $partner->user_id;
        User::where('id', $UID)->update(array('role_id' => '2'));
        $SelectedPartner->delete();
        return back();

    }

    public function addHotel(Partner $partner)
    {
        $facilities =Facility::pluck('name','id')->all();
        $array = ['Hải Châu','Thanh Khê ', 'Sơn Trà ', 'Ngũ Hành Sơn' ,
                 'Liên Chiểu', 'Hòa Vang' ,'Cẩm Lệ', 'Hoàng Sa'];
        return view('partners.addhotel', compact('partner','array','facilities'));
    }

    // Partner can View All the Hotels Confirmed Reservations
    public function HotelReservations(Hotel $hotel, Reservation $reservation)
    {

        $HotelId = $hotel->id;
        $Hotel = Hotel::find($HotelId);
        $Reservations = Reservation::where('hotel_id', '=', $HotelId)->get();

        return view('partners.hotels.viewReservations', compact('Reservations', 'Hotel'));
    }
    public function countyhc()
    {
            $Hotels = Hotel::where('County','Hải Châu')
            ->get();        
        return view('hotels.allhotels', compact('Hotels'));

    }
    public function countyst()
    {
            $Hotels = Hotel::where('County','Sơn Trà')
            ->get();        
        return view('hotels.allhotels', compact('Hotels'));

    }
    public function countylc()
    {
            $Hotels = Hotel::where('County','Liên Chiểu')
            ->get();        
        return view('hotels.allhotels', compact('Hotels'));

    }
}
