<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

/**
 * Seeds the permissions for the Phase 3 ISO modules.
 *
 * Idempotent — uses `firstOrCreate` so re-running is safe. Permissions
 * follow the existing project convention:
 *   <module>_management_access  → grants visibility of the module group
 *   <module>_access             → grants index/show within the module
 *   <module>_create / edit / show / delete  → per-action verbs
 */
class IsoModulesPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'sop_document' => 'Document Control',
            'equipment' => 'Equipment & Calibration',
            'reagent_lot' => 'Reagents',
            'non_conformance' => 'Quality — NCR & CAPA',
            'internal_audit' => 'Internal Audits',
            'competency' => 'Training & Competency',
            'risk' => 'Risk Register',
        ];

        foreach ($modules as $module => $group) {
            $titles = [
                "{$module}_management_access",
                "{$module}_access",
                "{$module}_create",
                "{$module}_edit",
                "{$module}_show",
                "{$module}_delete",
            ];

            foreach ($titles as $title) {
                Permission::firstOrCreate(
                    ['title' => $title],
                    ['group' => $group],
                );
            }
        }

        // Phase 5 — quality dashboard + cross-module reporting (TAT / QC /
        // pending result-release worklist). Kept separate from the
        // module-specific permissions so a "QMS reviewer" role can be
        // granted access to dashboards without needing every individual
        // module permission.
        $qualityTitles = [
            'quality_management_access',
            'quality_access',
            'quality_show',
            'qc_result_management_access',
            'qc_result_access',
            'qc_result_show',
        ];

        foreach ($qualityTitles as $title) {
            Permission::firstOrCreate(
                ['title' => $title],
                ['group' => 'Quality — Dashboards & Reporting'],
            );
        }
    }
}
