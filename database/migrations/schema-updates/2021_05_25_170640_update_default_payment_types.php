<?php

use App\Models\PaymentType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultPaymentTypes extends Migration
{
    public function up()
    {
        // Busca el admin por role_id o toma el primer usuario disponible
        $adminRole  =   Role::where( 'namespace', 'admin' )->first();
        $admin      =   null;

        if ( $adminRole ) {
            $admin  =   User::where( 'role_id', $adminRole->id )->first();
        }

        // Si no encuentra admin por rol, toma el primer usuario existente
        if ( ! $admin ) {
            $admin  =   User::first();
        }

        // Si aún no hay usuario, usa ID 1 como fallback
        $authorId   =   $admin ? $admin->id : 1;

        $paymentType                =   new PaymentType;
        $paymentType->label         =   __( 'Cash' );
        $paymentType->identifier    =   'cash-payment';
        $paymentType->readonly      =   true;
        $paymentType->author        =   $authorId;
        $paymentType->save();

        $paymentType                =   new PaymentType;
        $paymentType->label         =   __( 'Bank Payment' );
        $paymentType->identifier    =   'bank-payment';
        $paymentType->readonly      =   true;
        $paymentType->author        =   $authorId;
        $paymentType->save();

        $paymentType                =   new PaymentType;
        $paymentType->label         =   __( 'Customer Account' );
        $paymentType->identifier    =   'account-payment';
        $paymentType->readonly      =   true;
        $paymentType->author        =   $authorId;
        $paymentType->save();
    }

    public function down()
    {
        //
    }
}
