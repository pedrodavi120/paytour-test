<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envie seu Currículo - Paytour</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full space-y-8 bg-white p-10 rounded-xl shadow-md">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Envie seu Currículo
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Estamos em processo de aceleração e buscamos novos talentos!
                </p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                    <p class="font-bold">Sucesso!</p>
                    <p><?= htmlspecialchars($success_message) ?></p>
                </div>
            <?php else: ?>
                <form id="resume-form" class="mt-8 space-y-6" action="/" method="POST" enctype="multipart/form-data" novalidate>
                    <div class="rounded-md shadow-sm -space-y-px">
                        
                        <!-- Campo Nome -->
                        <div class="mb-4">
                            <label for="nome" class="sr-only">Nome Completo</label>
                            <input id="nome" name="nome" type="text" autocomplete="name" required
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border <?= isset($errors['nome']) ? 'border-red-500' : 'border-gray-300' ?> placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Nome Completo" value="<?= htmlspecialchars($old_data['nome'] ?? '') ?>">
                            <?php if (isset($errors['nome'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(current($errors['nome'])) ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Campo E-mail -->
                        <div class="mb-4">
                            <label for="email" class="sr-only">E-mail</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="E-mail" value="<?= htmlspecialchars($old_data['email'] ?? '') ?>">
                             <?php if (isset($errors['email'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(current($errors['email'])) ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Campo Telefone -->
                        <div class="mb-4">
                            <label for="telefone" class="sr-only">Telefone</label>
                            <input id="telefone" name="telefone" type="tel" autocomplete="tel" required
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border <?= isset($errors['telefone']) ? 'border-red-500' : 'border-gray-300' ?> placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Telefone (com DDD)" value="<?= htmlspecialchars($old_data['telefone'] ?? '') ?>">
                            <?php if (isset($errors['telefone'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(current($errors['telefone'])) ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Campo Cargo Desejado -->
                        <div class="mb-4">
                            <label for="cargo_desejado" class="sr-only">Cargo Desejado</label>
                            <input id="cargo_desejado" name="cargo_desejado" type="text" required
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border <?= isset($errors['cargo_desejado']) ? 'border-red-500' : 'border-gray-300' ?> placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Cargo Desejado" value="<?= htmlspecialchars($old_data['cargo_desejado'] ?? '') ?>">
                            <?php if (isset($errors['cargo_desejado'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(current($errors['cargo_desejado'])) ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Campo Escolaridade -->
                        <div class="mb-4">
                            <label for="escolaridade" class="sr-only">Escolaridade</label>
                            <select id="escolaridade" name="escolaridade" required
                                    class="appearance-none rounded-md relative block w-full px-3 py-2 border <?= isset($errors['escolaridade']) ? 'border-red-500' : 'border-gray-300' ?> bg-white placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                <option value="" disabled <?= !isset($old_data['escolaridade']) ? 'selected' : '' ?>>Selecione a Escolaridade</option>
                                <option value="Ensino Médio" <?= (isset($old_data['escolaridade']) && $old_data['escolaridade'] == 'Ensino Médio') ? 'selected' : '' ?>>Ensino Médio</option>
                                <option value="Técnico" <?= (isset($old_data['escolaridade']) && $old_data['escolaridade'] == 'Técnico') ? 'selected' : '' ?>>Técnico</option>
                                <option value="Graduação Incompleta" <?= (isset($old_data['escolaridade']) && $old_data['escolaridade'] == 'Graduação Incompleta') ? 'selected' : '' ?>>Graduação Incompleta</option>
                                <option value="Graduação Completa" <?= (isset($old_data['escolaridade']) && $old_data['escolaridade'] == 'Graduação Completa') ? 'selected' : '' ?>>Graduação Completa</option>
                                <option value="Pós-graduação" <?= (isset($old_data['escolaridade']) && $old_data['escolaridade'] == 'Pós-graduação') ? 'selected' : '' ?>>Pós-graduação</option>
                            </select>
                             <?php if (isset($errors['escolaridade'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(current($errors['escolaridade'])) ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Campo Observações -->
                        <div class="mb-4">
                            <label for="observacoes" class="sr-only">Observações</label>
                            <textarea id="observacoes" name="observacoes" rows="4"
                                      class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                      placeholder="Observações (opcional)"><?= htmlspecialchars($old_data['observacoes'] ?? '') ?></textarea>
                        </div>
                        
                        <!-- Campo Arquivo -->
                        <div class="mb-4">
                            <label for="arquivo" class="block text-sm font-medium text-gray-700">Currículo (PDF, DOC, DOCX - máx 1MB)</label>
                            <input id="arquivo" name="arquivo" type="file" required
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 <?= isset($errors['arquivo']) ? 'border-red-500' : '' ?>">
                             <?php if (isset($errors['arquivo'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(current($errors['arquivo'])) ?></p>
                             <?php endif; ?>
                             <p id="file-error-message" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                    </div>

                    <div>
                        <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-indigo-300">
                            Enviar Currículo
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>

