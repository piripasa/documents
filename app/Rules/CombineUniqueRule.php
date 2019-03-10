<?php
namespace App\Rules;

class CombineUniqueRule implements RuleInterface {

    public function validate($attribute, $value, $parameters, $validator): bool
    {
        if (count($parameters) > 0 ) {
            $validator->addReplacer('combine_unique', function($message, $attribute, $rule, $parameters) use ($value) {
                return str_replace([':attribute', ':value'], [$attribute, $value], $message);
            });

            $where = [];
            $table = $parameters[0];
            $data = $validator->getData();
            foreach($parameters as $key => $field) {
                if($key == 0 ) {
                    continue;
                }
                $xf = explode("->", $field);
                $where[$xf[0]] = $xf[1] ?? $data[$xf[0]];
            }

            if( empty($where) ) {
                $where[$attribute] = $value;
            }

            $qb = app('db')->table($table);
            foreach($where as $field => $value) {
                if( $value === 'NULL' ) {
                    $qb->whereNull($field);
                    continue;
                }

                $qb->where($field, $value);
            }

            return $qb->count() === 0;
        }

        return true;
    }
}
