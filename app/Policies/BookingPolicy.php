<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //Admin and Cleaners  can see the list, Customers too (but filtered)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
   public function view(User $user, Booking $booking): bool
{
    // 1. Admins can see everything
    if ($user->role === 'admin') {
        return true;
    }

    // 2. Cleaners can see if they are assigned
    if ($user->role === 'cleaner') {
        return $booking->cleaners->contains($user->id);
    }

    // 3. Customers can see if the email matches
    // IMPORTANT: Ensure $booking->customer_email matches $user->email exactly
    return trim(strtolower($user->email)) === trim(strtolower($booking->customer_email));
}

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }

    // 4. Specifically for Many-to-Many Assignments (The "Assign" Button)
    public function attachAny(User $user, Booking $booking): bool
    {
        return $user->role === 'admin';
    }

    public function detach(User $user, Booking $booking, User $cleaner): bool
    {
        return $user->role === 'admin';
    }
}
