<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Title('Form Event')]
class EventForm extends Component
{
    use WithFileUploads;

    public ?Event $event = null;
    public $eventId = null;

    // Form fields
    public $title = '';
    public $content = '';
    public $images = [];          // Temporary upload holder
    public $newImages = [];       // Accumulated new images for preview
    public $existingImages = [];
    public $start_date = '';
    public $end_date = '';
    public $registration_start = '';
    public $registration_end = '';
    public $is_paid = false;
    public $price = 0;
    public $has_attendance = false;
    public $has_certificate = false;
    public $certificate_template;
    public $existingCertificate = '';
    public $certificate_font = 'Arial';
    public $certificate_font_color = '#000000';
    public $certificate_font_size = 24;
    public $certificate_name_x = 400;
    public $certificate_name_y = 300;
    public $status = 'draft';

    // Group links
    public $group_ikhwan = '';
    public $group_akhwat = '';
    public $group_public = '';

    // Quota
    public $quota_ikhwan = null;
    public $quota_akhwat = null;

    // Auto accept registration
    public $auto_accept = false;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'content' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'is_paid' => 'boolean',
            'price' => 'required_if:is_paid,true|numeric|min:0',
            'has_attendance' => 'boolean',
            'has_certificate' => 'boolean',
            'certificate_template' => 'nullable|image|max:4096',
            'certificate_font' => 'nullable|string',
            'certificate_font_color' => 'nullable|string',
            'certificate_font_size' => 'nullable|integer|min:10|max:100',
            'certificate_name_x' => 'nullable|integer',
            'certificate_name_y' => 'nullable|integer',
            'status' => 'required|in:draft,published,closed',
            'group_ikhwan' => 'nullable|url|max:500',
            'group_akhwat' => 'nullable|url|max:500',
            'group_public' => 'nullable|url|max:500',
            'quota_ikhwan' => 'nullable|integer|min:1',
            'quota_akhwat' => 'nullable|integer|min:1',
            'auto_accept' => 'boolean',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->event = Event::findOrFail($id);
            $this->eventId = $id;
            $this->title = $this->event->title;
            $this->content = $this->event->content;
            $this->existingImages = $this->event->getAllImages();
            $this->start_date = $this->event->start_date->format('Y-m-d\TH:i');
            $this->end_date = $this->event->end_date->format('Y-m-d\TH:i');
            $this->registration_start = $this->event->registration_start?->format('Y-m-d\TH:i') ?? '';
            $this->registration_end = $this->event->registration_end?->format('Y-m-d\TH:i') ?? '';
            $this->is_paid = $this->event->is_paid;
            $this->price = $this->event->price;
            $this->has_attendance = $this->event->has_attendance;
            $this->has_certificate = $this->event->has_certificate;
            $this->existingCertificate = $this->event->certificate_template;
            $this->certificate_font = $this->event->certificate_font;
            $this->certificate_font_color = $this->event->certificate_font_color;
            $this->certificate_font_size = $this->event->certificate_font_size;
            $this->certificate_name_x = $this->event->certificate_name_x;
            $this->certificate_name_y = $this->event->certificate_name_y;
            $this->status = $this->event->status;
            $this->group_ikhwan = $this->event->group_ikhwan ?? '';
            $this->group_akhwat = $this->event->group_akhwat ?? '';
            $this->group_public = $this->event->group_public ?? '';
            $this->quota_ikhwan = $this->event->quota_ikhwan;
            $this->quota_akhwat = $this->event->quota_akhwat;
            $this->auto_accept = $this->event->auto_accept;
        }
    }

    public function removeExistingImage($index)
    {
        if (isset($this->existingImages[$index])) {
            array_splice($this->existingImages, $index, 1);
            $this->existingImages = array_values($this->existingImages);
        }
    }

    public function removeNewImage($index)
    {
        if (isset($this->newImages[$index])) {
            array_splice($this->newImages, $index, 1);
            $this->newImages = array_values($this->newImages);
        }
    }

    public function updatedImages()
    {
        // Validate uploaded images
        $this->validateOnly('images.*');

        // Get remaining slots
        $existingCount = is_array($this->existingImages) ? count($this->existingImages) : 0;
        $newCount = is_array($this->newImages) ? count($this->newImages) : 0;
        $remainingSlots = 5 - $existingCount - $newCount;

        // Add new images to accumulated array (up to remaining slots)
        if (!empty($this->images) && is_array($this->images)) {
            foreach ($this->images as $image) {
                if ($remainingSlots > 0 && $image) {
                    $this->newImages[] = $image;
                    $remainingSlots--;
                }
            }
        }

        // Clear temporary holder
        $this->images = [];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'registration_start' => $this->registration_start ?: null,
            'registration_end' => $this->registration_end ?: null,
            'is_paid' => $this->is_paid,
            'price' => $this->is_paid ? $this->price : 0,
            'has_attendance' => $this->has_attendance,
            'has_certificate' => $this->has_certificate,
            'certificate_font' => $this->certificate_font,
            'certificate_font_color' => $this->certificate_font_color,
            'certificate_font_size' => $this->certificate_font_size,
            'certificate_name_x' => $this->certificate_name_x,
            'certificate_name_y' => $this->certificate_name_y,
            'status' => $this->status,
            'group_ikhwan' => $this->group_ikhwan ?: null,
            'group_akhwat' => $this->group_akhwat ?: null,
            'group_public' => $this->group_public ?: null,
            'quota_ikhwan' => $this->quota_ikhwan ?: null,
            'quota_akhwat' => $this->quota_akhwat ?: null,
            'auto_accept' => $this->auto_accept,
        ];

        // Generate slug for new events
        if (!$this->eventId) {
            $data['slug'] = Event::generateSlug($this->title);
        }

        // Handle multiple images upload
        $uploadedImages = is_array($this->existingImages) ? $this->existingImages : [];

        if (!empty($this->newImages) && is_array($this->newImages)) {
            // Ensure directory exists (Windows compatible path)
            $uploadPath = public_path('berkas' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR . 'images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($this->newImages as $image) {
                if ($image && $image->getRealPath()) {
                    $extension = $image->getClientOriginalExtension() ?: 'jpg';
                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $extension;
                    $destination = $uploadPath . DIRECTORY_SEPARATOR . $filename;

                    // Use copy instead of move for Windows compatibility
                    if (copy($image->getRealPath(), $destination)) {
                        $uploadedImages[] = $filename;
                    }
                }
            }
        }

        // Always set images field (limit to max 5)
        $data['images'] = array_slice($uploadedImages, 0, 5);

        // Handle certificate template upload
        if ($this->certificate_template && $this->certificate_template->getRealPath()) {
            $certPath = public_path('berkas' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR . 'certificates');
            if (!file_exists($certPath)) {
                mkdir($certPath, 0755, true);
            }
            $extension = $this->certificate_template->getClientOriginalExtension() ?: 'jpg';
            $filename = date('Y-m-d-H-i-s') . '-cert.' . $extension;
            $destination = $certPath . DIRECTORY_SEPARATOR . $filename;

            if (copy($this->certificate_template->getRealPath(), $destination)) {
                $data['certificate_template'] = $filename;
            }
        }

        if ($this->eventId) {
            $this->event->update($data);
            session()->flash('success', 'Event berhasil diperbarui!');
        } else {
            Event::create($data);
            session()->flash('success', 'Event berhasil dibuat!');
        }

        return redirect()->route('admin::events.index');
    }

    public function render()
    {
        $title = $this->eventId ? 'Edit Event' : 'Buat Event Baru';
        return view('livewire.admin.events.event-form')
            ->layout('layouts.app', ['title' => $title]);
    }
}
