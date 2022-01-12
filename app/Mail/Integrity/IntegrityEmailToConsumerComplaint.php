<?php

namespace App\Mail\Integrity;

use App;
use App\Helpers\EmailValidationHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IntegrityEmailToConsumerComplaint extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($input, $user)
    {
        $this->input = $input;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Email Address To
        $inputArray['emailTos'] = explode(";", $this->input['to'] ?? '');

        if (App::environment(['production'])) {
            $inputArray['emailTos'] = array_prepend($inputArray['emailTos'], 'e-aduan@kpdnhep.gov.my');
        }

        foreach($inputArray['emailTos'] as $key => $email) {
            // Remove all illegal characters from e-mail
            $inputArray['emailTos'][$key] = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate e-mail
            if (!EmailValidationHelper::validEmail($inputArray['emailTos'][$key])) {
                $inputArray['emailTos'] = array_except($inputArray['emailTos'], [$key]);
            }
        }
        $inputArray['emailToValues'] = array_values($inputArray['emailTos']);

        // Email Address Cc
        $inputArray['emailCcs'] = explode(";", $this->input['cc'] ?? '');

        foreach($inputArray['emailCcs'] as $key => $email) {
            // Remove all illegal characters from e-mail
            $inputArray['emailCcs'][$key] = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate e-mail
            if (!EmailValidationHelper::validEmail($inputArray['emailCcs'][$key])) {
                $inputArray['emailCcs'] = array_except($inputArray['emailCcs'], [$key]);
            }
        }
        $inputArray['emailCcValues'] = array_values($inputArray['emailCcs']);

        // Email Address Bcc
        $inputArray['emailBccs'] = explode(";", $this->input['bcc'] ?? '');

        foreach($inputArray['emailBccs'] as $key => $email) {
            // Remove all illegal characters from e-mail
            $inputArray['emailBccs'][$key] = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate e-mail
            if (!EmailValidationHelper::validEmail($inputArray['emailBccs'][$key])) {
                $inputArray['emailBccs'] = array_except($inputArray['emailBccs'], [$key]);
            }
        }
        $inputArray['emailBccValues'] = array_values($inputArray['emailBccs']);

        $mail = $this->from($this->user->email ?? '')
            ->to($inputArray['emailToValues'])
            ->cc($inputArray['emailCcValues'])
            ->bcc($inputArray['emailBccValues'])
            ->subject($this->input['title'] ?? 'Integriti : Aduan Kepenggunaan')
            ->view('emails.integrity.sendtoconsumercomplaint')
            ->with([
                'input' => $this->input,
                'user' => $this->user,
            ]);
        return $mail;
    }
}
