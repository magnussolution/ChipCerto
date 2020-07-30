*****************
Criar um usuário
*****************

Adicionar novas contas de usuários a `MagnusBilling`_ .

Nos dirigimos ao Menú Usuarios >> Usuarios >> Novo. Encontramos os campos:

- Usuario: Ingresamos o nome de usuário (Podemos selecionar para que `MagnusBilling`_ . gere este dado de manera automática, desde o Menú Configuraçōes >> Configuraçōes >> Username auto generate, como assim también podemos escolher que se coloque um prefixo e a quantidade de caracteres). É recomendable colocar um nome de usuário formado por números e não  por letras.

- Senha: A senha sempre se genera de manera automática, mas pode ser modificada posteriormente pelo Administrador, o inclusive pelo o usuário, se o usuário tem as permissōes correspondentes.

- Grupo: Este campo indica a que grupo vai pertencer o usuário. Por padrão `MagnusBilling`_ . tem 3 grupos: Administrador, Agente e Cliente; mas se poden criar e generar novos. Cada uno com os permissōes deseados. É recomendable não  modificar os grupos que trae `MagnusBilling`_ . por padrão.

- Grupo para clientes do Agente: Em caso de que se selecione um Grupo de Agente, mem este campo se poderá escolher a que grupo vão pertencer os usuário creados por este agente.

- Idioma: Se deve selecionar o idioma do usuário.

- Plano: Este campo indica a que planoo vai pertencer este usuário, por tanto qual será os valores que vai pagar pelas chamadas, ja que cada plano, tem suas tarifas.

- DDD: Neste campo podemos gerar um plano de marcado específico para cada usuário. O formato é o seguinte:

Exemplo de plano de discagem: 0/55,*/5511/8,*/5511/9

As regras devem estar separadas por virgula (,) e estão compostas por tres termino separados por "/". O primeiro termino indica o número a encontrar e ser alterado, o segundo por qual deve ser reemplazado, o terceiro é a longitude do número. 

Exemplo 1: 15/54911/10. Número que inicia com 15 e tenha uma longitud de 10 dígitos, se deve trocar o 15 pelo 54911. Número 1561333612 >> inicia com 15 e tem 10 dígitos = 5491161333612

Exemplo 2: 0342/54342/11. Número que inicia com 0342 e tenha uma longitud de 11 dígitos, alterar o 0342 pelo 54342. Número 03424742900 >> inicia com 0342 e tem 11 dígitos = 543424742900


- Ativo: Ativamos o desativamos este usuário, si se encontra desativado, não podera ingressar ao sistema.

- Pacotes gratis: Este campo indica si o usuário tem ativado algum pacte gratis.



Tab dados pessoais: Se poderá adicionar informação detalhada do usuário.



Tab Adicional

- Tipo de pagamento: Pré-pago o Pós-pago.

- Limite de crédito: Caso de selecionar Pós-pago, se poderá selecionar o límite de crédito com o qual o usuário poderá realizar chamadas.

- Ativar vencimiento: Para ativar o vencimiento do crédito. Ao chegar no limite, o usuário sera desativado.

- Vence: Indicar a fecha de caducidad. 

- Aviso saldo baixo: Envía alertas por email ao usuário quando saldo for menor que o valor adicionado.

- Callshop: Ativar o módulo callshop para este usuário.

- Gravar chamadas: Gravar as chamadas de este usuário.

- PIN Callingcard: PIN para que o usuário pode entrar ao callingcard (se genera de manera aleatoria, mas se pode modificar).

- Restriçōes: Que tipo de restriçōes de chamada tera o usuário. (Ler documentação: Usuarios >> Números restringidos).
  

.. _MagnusBilling: https://www.magnusbilling.com
