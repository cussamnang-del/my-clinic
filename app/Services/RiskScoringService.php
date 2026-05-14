<?php

namespace App\Services;

use App\Models\Risk;
use InvalidArgumentException;

/**
 * Computes inherent and residual risk scores using a standard 5×5 matrix.
 *
 * Both inputs (likelihood, severity) must be integers in [1, 5]; the
 * resulting score is in [1, 25].
 *
 * Score → band:
 *   ≥ 20  → extreme
 *   ≥ 12  → high
 *   ≥  6  → medium
 *   else  → low
 *
 * Bands match `Risk::band()` so the model accessor and this service
 * agree on classification.
 */
class RiskScoringService
{
    /**
     * Compute inherent and residual scores and persist them on the
     * given Risk. The model is expected to have likelihood/severity
     * (and optionally residual_likelihood/residual_severity) already
     * assigned.
     */
    public function score(Risk $risk): Risk
    {
        $risk->score = $this->multiply($risk->likelihood, $risk->severity, inherent: true);

        if ($risk->residual_likelihood !== null && $risk->residual_severity !== null) {
            $risk->residual_score = $this->multiply(
                $risk->residual_likelihood,
                $risk->residual_severity,
                inherent: false,
            );
        }

        $risk->save();

        return $risk->fresh();
    }

    /**
     * Pure scoring helper — handy in seeders/tests where you have raw
     * inputs and don't want to instantiate a model first.
     */
    public function compute(int $likelihood, int $severity): int
    {
        return $this->multiply($likelihood, $severity, inherent: true);
    }

    private function multiply(?int $likelihood, ?int $severity, bool $inherent): int
    {
        $label = $inherent ? 'inherent' : 'residual';
        if ($likelihood === null || $severity === null) {
            throw new InvalidArgumentException(
                "Cannot compute {$label} risk score without both likelihood and severity."
            );
        }

        if ($likelihood < 1 || $likelihood > 5 || $severity < 1 || $severity > 5) {
            throw new InvalidArgumentException(
                "{$label} likelihood and severity must each be in the range 1..5."
            );
        }

        return $likelihood * $severity;
    }
}
