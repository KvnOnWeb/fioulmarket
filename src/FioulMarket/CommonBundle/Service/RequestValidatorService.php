<?php
namespace FioulMarket\CommonBundle\Service;

use HadesArchitect\JsonSchemaBundle\Validator\ValidatorService;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-09
 */
class RequestValidatorService
{
    private $schemaPath;
    private $validator;

    /**
     * @param ValidatorService $validator
     * @param string           $schemaPath
     */
    public function __construct(ValidatorService $validator, $schemaPath = '')
    {
        $this->schemaPath = $schemaPath;
        $this->validator  = $validator;
    }

    /**
     * @param Request $request
     * @param string  $validatorSchema
     *
     * @return bool
     */
    public function isValidRequest(Request $request, $validatorSchema)
    {
        $data   = $request->getContent();
        $schema = $this->getSchema($validatorSchema);
        return $this->validator->isValid($data, $schema);
    }

    /**
     * @param $schema
     *
     * @return mixed
     *
     * @throws \Exception
     */
    private function getSchema($schema)
    {
        $schemaValidationPath = 'file://' . $this->schemaPath . $schema;
        if (!file_exists($schemaValidationPath)) {
            throw new \Exception(sprintf('The json validation schema %s does not exist', $schemaValidationPath), 500);
        }
        $jsonSchema = json_decode(file_get_contents($schemaValidationPath));
        if (false === $jsonSchema) {
            throw new \Exception(sprintf('The json schema %s is not valid', $schemaValidationPath), 500);
        }
        return $jsonSchema;
    }

    /**
     * @param string $schemaPath
     */
    public function setSchemaPath(string $schemaPath)
    {
        $this->schemaPath = $schemaPath;
    }

    /**
     * @return array
     */
    public function getLastErrorMessages()
    {
        return $this->validator->getErrors();
    }
}
