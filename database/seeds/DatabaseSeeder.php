<?php

use App\Core\Database;
use App\Models\User;
use App\Models\Package;
use App\Models\Node;

class DatabaseSeeder
{
    private Database $db;
    private User $userModel;
    private Package $packageModel;
    private Node $nodeModel;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->userModel = new User($db, new \App\Security\Csrf(new \App\Helpers\Session($db)));
        $this->packageModel = new Package($db);
        $this->nodeModel = new Node($db);
    }

    public function run(): void
    {
        $this->seedOwner();
        $this->seedPackages();
        $this->seedDefaultNode();
    }

    private function seedOwner(): void
    {
        $existing = $this->userModel->findByUsername('Emanuel');
        if ($existing) {
            echo "Owner account already exists.\n";
            return;
        }

        // Password: Dreimuskletiere.com
        $passwordHash = password_hash('Dreimuskletiere.com', PASSWORD_ARGON2ID);

        $this->userModel->create([
            'username' => 'Emanuel',
            'email' => 'emanuel@manu-hosting.de',
            'password' => $passwordHash,
            'role' => 'owner',
            'status' => 'active',
            'email_verified' => 1,
        ]);

        echo "Owner account created: Emanuel / Dreimuskletiere.com\n";
    }

    private function seedPackages(): void
    {
        $packages = [
            [
                'name' => 'Starter',
                'description' => 'Perfekt für kleine Server mit Freunden',
                'ram' => 2048,
                'cpu' => 2,
                'disk' => 10,
                'player_slots' => 10,
                'price_monthly' => 4.99,
                'price_quarterly' => 13.99,
                'price_semi_annual' => 25.99,
                'price_annual' => 49.99,
                'features' => json_encode([
                    'Automatische Backups (täglich)',
                    'DDoS-Schutz',
                    'Mod/Plugin-Support',
                    'Web-Konsole',
                    'Dateimanager',
                ]),
                'sort_order' => 1,
            ],
            [
                'name' => 'Builder',
                'description' => 'Für mittlere Server und Communities',
                'ram' => 4096,
                'cpu' => 4,
                'disk' => 20,
                'player_slots' => 30,
                'price_monthly' => 9.99,
                'price_quarterly' => 27.99,
                'price_semi_annual' => 52.99,
                'price_annual' => 99.99,
                'features' => json_encode([
                    'Automatische Backups (täglich)',
                    'DDoS-Schutz',
                    'Mod/Plugin-Support',
                    'Web-Konsole',
                    'Dateimanager',
                    'Prioritärer Support',
                    'Mehrere Welten',
                ]),
                'sort_order' => 2,
            ],
            [
                'name' => 'Pro',
                'description' => 'Für große Server und Networks',
                'ram' => 8192,
                'cpu' => 6,
                'disk' => 50,
                'player_slots' => 60,
                'price_monthly' => 19.99,
                'price_quarterly' => 54.99,
                'price_semi_annual' => 104.99,
                'price_annual' => 199.99,
                'features' => json_encode([
                    'Automatische Backups (stündlich)',
                    'DDoS-Schutz',
                    'Mod/Plugin-Support',
                    'Web-Konsole',
                    'Dateimanager',
                    'Prioritärer Support',
                    'Mehrere Welten',
                    'Dedicated IP',
                    'Custom JAR Support',
                ]),
                'sort_order' => 3,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Maximale Leistung für professionelle Networks',
                'ram' => 16384,
                'cpu' => 8,
                'disk' => 100,
                'player_slots' => 100,
                'price_monthly' => 39.99,
                'price_quarterly' => 109.99,
                'price_semi_annual' => 209.99,
                'price_annual' => 399.99,
                'features' => json_encode([
                    'Automatische Backups (stündlich)',
                    'DDoS-Schutz (Premium)',
                    'Mod/Plugin-Support',
                    'Web-Konsole',
                    'Dateimanager',
                    '24/7 Priority Support',
                    'Mehrere Welten',
                    'Dedicated IP',
                    'Custom JAR Support',
                    'SLA Garantie',
                    'Eigener Node-Bereich',
                ]),
                'sort_order' => 4,
            ],
        ];

        foreach ($packages as $package) {
            $existing = $this->db->queryOne("SELECT id FROM packages WHERE name = ?", [$package['name']]);
            if (!$existing) {
                $this->packageModel->create($package);
                echo "Package created: {$package['name']}\n";
            }
        }
    }

    private function seedDefaultNode(): void
    {
        $existing = $this->nodeModel->findByToken('default_node_token');
        if ($existing) {
            return;
        }

        $this->nodeModel->create([
            'name' => 'DL580 Primary',
            'host' => '127.0.0.1',
            'api_port' => 8443,
            'token' => 'default_node_token',
            'status' => 'offline',
            'cpu_cores' => 40,
            'ram_total' => 274877906944, // 256 GB in bytes
            'disk_total' => 2199023255552, // 2 TB in bytes
        ]);

        echo "Default node created: DL580 Primary\n";
    }
}
