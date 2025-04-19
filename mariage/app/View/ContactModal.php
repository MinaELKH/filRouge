<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ContactModal extends Component
{

    public $receiverId;
    public $serviceId;

    public function __construct($receiverId, $serviceId)
    {
        $this->receiverId = $receiverId;
        $this->serviceId = $serviceId;
    }

    public function render()
    {
        return view('components.contact-modal');
    }
}
