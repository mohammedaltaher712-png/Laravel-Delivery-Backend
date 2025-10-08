<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected string $projectId;
    protected string $serviceAccountPath;

    public function __construct()
    {
        $this->projectId = 'foodapps-e21a0';
        $this->serviceAccountPath = storage_path('firebase/firebase-admin.json');

        if (!file_exists($this->serviceAccountPath)) {
            throw new \Exception("Firebase Service Account file not found.");
        }
    }

    protected function getAccessToken(): ?string
    {
        $scope = 'https://www.googleapis.com/auth/firebase.messaging';
        $cred = new ServiceAccountCredentials($scope, $this->serviceAccountPath);
        $authToken = $cred->fetchAuthToken();

        return $authToken['access_token'] ?? null;
    }

    public function sendToTopic(string $topic, string $title, string $body, $pageId = 'none', $pageName = 'none')
    {
        $accessToken = $this->getAccessToken();
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => [
                        'pageid' => $pageId,
                        'pagename' => $pageName,
                    ],
                ]
            ]);

        return $response->json();
    }
}
