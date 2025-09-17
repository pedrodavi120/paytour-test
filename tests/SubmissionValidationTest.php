<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Rakit\Validation\Validator;

class SubmissionValidationTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator;
        // Definindo mensagens de erro para consistência nos testes
        $this->validator->setMessages([
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O e-mail informado não é válido.',
            'in' => 'O valor selecionado para :attribute é inválido.',
            'uploaded_file' => 'Arquivo inválido.'
        ]);
    }

    private function getValidData(array $overrides = []): array
    {
        return array_merge([
            'nome' => 'Candidato Teste',
            'email' => 'teste@example.com',
            'telefone' => '84999999999',
            'cargo_desejado' => 'Desenvolvedor PHP',
            'escolaridade' => 'Graduação Completa',
            'observacoes' => '',
            'arquivo' => [
                'name' => 'curriculo.pdf',
                'type' => 'application/pdf',
                'tmp_name' => '/tmp/php123',
                'error' => 0,
                'size' => 500000 // 0.5 MB
            ]
        ], $overrides);
    }

    public function testValidationSucceedsWithValidData()
    {
        $data = $this->getValidData();
        $validation = $this->makeValidation($data);
        $this->assertFalse($validation->fails());
    }

    public function testValidationFailsWhenNameIsMissing()
    {
        $data = $this->getValidData(['nome' => '']);
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('nome', $validation->errors()->toArray());
    }
    
    public function testValidationFailsWithInvalidEmail()
    {
        $data = $this->getValidData(['email' => 'email-invalido']);
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('email', $validation->errors()->toArray());
    }

    public function testValidationFailsWhenPhoneIsMissing()
    {
        $data = $this->getValidData(['telefone' => '']);
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('telefone', $validation->errors()->toArray());
    }
    
    public function testValidationFailsWithInvalidEducationLevel()
    {
        $data = $this->getValidData(['escolaridade' => 'Doutorado']); // Não é uma opção válida
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('escolaridade', $validation->errors()->toArray());
    }
    
    public function testValidationFailsWhenFileIsMissing()
    {
        $data = $this->getValidData(['arquivo' => null]);
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('arquivo', $validation->errors()->toArray());
    }

    public function testValidationFailsWithInvalidFileType()
    {
        $file = $this->getValidData()['arquivo'];
        $file['name'] = 'imagem.jpg';
        $file['type'] = 'image/jpeg';
        
        $data = $this->getValidData(['arquivo' => $file]);
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('arquivo', $validation->errors()->toArray());
    }
    
    public function testValidationFailsWhenFileIsTooLarge()
    {
        $file = $this->getValidData()['arquivo'];
        $file['size'] = 2000000; // 2MB
        
        $data = $this->getValidData(['arquivo' => $file]);
        $validation = $this->makeValidation($data);
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('arquivo', $validation->errors()->toArray());
    }

    private function makeValidation(array $data)
    {
        $validation = $this->validator->make($data, [
            'nome'             => 'required|alpha_spaces',
            'email'            => 'required|email',
            'telefone'         => 'required',
            'cargo_desejado'   => 'required',
            'escolaridade'     => 'required|in:Ensino Médio,Técnico,Graduação Incompleta,Graduação Completa,Pós-graduação',
            'observacoes'      => 'present',
            'arquivo'          => 'required|uploaded_file:0,1M,doc,docx,pdf',
        ]);

        $validation->validate();
        return $validation;
    }
}
