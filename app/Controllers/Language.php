<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Language extends Controller
{
    /**
     * Set the user's preferred language
     *
     * @param string $locale The locale to set (e.g., 'en', 'sw')
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function setLanguage($locale = 'en')
    {
        // Validate locale
        $validLocales = ['en', 'sw'];
        if (!in_array($locale, $validLocales)) {
            $locale = 'en'; // Default to English if invalid
        }

        // Set the locale in the session
        session()->set('locale', $locale);

        // Redirect back to previous page to preserve user activity
        $referer = $this->request->getServer('HTTP_REFERER');
        if ($referer) {
            return redirect()->to($referer);
        }
        return redirect()->back();
    }
}