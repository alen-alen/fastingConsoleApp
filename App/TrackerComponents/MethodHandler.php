<?php

namespace App\TrackerComponents;

class MethodHandler
{
    public function run(array $options, int $input, bool $fastStatus, string $filterBy): ?string
    {
        $input = (int)$input - 1;

        $filteredOptions = $this->filterOptions($options, $fastStatus);

        if (array_key_exists($input, $filteredOptions)) {
            $selectedAction = $filteredOptions[$input][$filterBy];

            return (string)$selectedAction;
        } else {
            return 'tryAgain';
        }
    }

    public function filterOptions(array $options, bool $fastStatus): array
    {
        if ($fastStatus == true) {
            return $this->filter($options, 'ACTIVE');
        } else {
            return $this->filter($options, 'NOT_ACTIVE');
        }
    }

    private function filter($options, $flag): array
    {
        return  array_values(
            array_filter(
                $options,
                function ($value) use ($flag) {

                    return $value['flag'] == $flag;
                }
            )
        );
    }
}
