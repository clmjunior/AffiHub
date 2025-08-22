<?php

namespace app\controllers\user;

class ListUsersController extends UserController
{
    public function indexListUsers()
    { 
        $users = $this->getUsers();

        $this->view('user', ['title' => 'Listagem de Usuários', 'name' => 'user', 'users' => $users]);
    }

    public function getUsers()
    {
        $users = [
            ['id' => 1, 'nome' => 'Thiago Gomes', 'email' => 'novaesandre@ig.com.br', 'tipo' => 'Usuário'],
            ['id' => 2, 'nome' => 'Paulo da Cunha', 'email' => 'levi50@bol.com.br', 'tipo' => 'Admin'],
            ['id' => 3, 'nome' => 'Sr. Lucas Gomes', 'email' => 'pda-mota@cunha.br', 'tipo' => 'Usuário'],
            ['id' => 4, 'nome' => 'Marcelo Castro', 'email' => 'nina73@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 5, 'nome' => 'Evelyn Lima', 'email' => 'heitor29@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 6, 'nome' => 'Nina Costela', 'email' => 'ramosgabriela@bol.com.br', 'tipo' => 'Admin'],
            ['id' => 7, 'nome' => 'Bruna Moura', 'email' => 'ealves@almeida.br', 'tipo' => 'Usuário'],
            ['id' => 8, 'nome' => 'João Cardoso', 'email' => 'ccaldeira@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 9, 'nome' => 'Srta. Larissa Gonçalves', 'email' => 'da-rosaeloah@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 10, 'nome' => 'Ian Ferreira', 'email' => 'caldeirabryan@pinto.br', 'tipo' => 'Admin'],
            ['id' => 11, 'nome' => 'Sarah Rezende', 'email' => 'nascimentosophie@campos.com', 'tipo' => 'Usuário'],
            ['id' => 12, 'nome' => 'Bruno Alves', 'email' => 'da-conceicaoemanuel@castro.com', 'tipo' => 'Admin'],
            ['id' => 13, 'nome' => 'Heitor Caldeira', 'email' => 'heitorcaldeira@vieira.com', 'tipo' => 'Usuário'],
            ['id' => 14, 'nome' => 'Miguel Caldeira', 'email' => 'camposrenan@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 15, 'nome' => 'Maria Clara Lima', 'email' => 'luiz-otaviopeixoto@bol.com.br', 'tipo' => 'Usuário'],
            ['id' => 16, 'nome' => 'Marcelo Rocha', 'email' => 'isis92@uol.com.br', 'tipo' => 'Admin'],
            ['id' => 17, 'nome' => 'Kaique das Neves', 'email' => 'milena05@souza.br', 'tipo' => 'Usuário'],
            ['id' => 18, 'nome' => 'Pedro Azevedo', 'email' => 'pcaldeira@da.com', 'tipo' => 'Admin'],
            ['id' => 19, 'nome' => 'João Guilherme da Rocha', 'email' => 'pcaldeira@bol.com.br', 'tipo' => 'Usuário'],
            ['id' => 20, 'nome' => 'Heloísa Santos', 'email' => 'ualmeida@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 21, 'nome' => 'Maitê Santos', 'email' => 'henriquevieira@campos.net', 'tipo' => 'Usuário'],
            ['id' => 22, 'nome' => 'Ana Dias', 'email' => 'araujolaura@alves.br', 'tipo' => 'Admin'],
            ['id' => 23, 'nome' => 'Isaac Sales', 'email' => 'kaiquerocha@bol.com.br', 'tipo' => 'Usuário'],
            ['id' => 24, 'nome' => 'Catarina Campos', 'email' => 'gnogueira@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 25, 'nome' => 'André Pereira', 'email' => 'andre11@fogaca.com', 'tipo' => 'Usuário'],
            ['id' => 26, 'nome' => 'Sophia Sales', 'email' => 'sarahjesus@caldeira.br', 'tipo' => 'Admin'],
            ['id' => 27, 'nome' => 'Maria Eduarda Azevedo', 'email' => 'valentinajesus@ig.com.br', 'tipo' => 'Usuário'],
            ['id' => 28, 'nome' => 'Dr. Enrico da Cruz', 'email' => 'luanamoura@da.br', 'tipo' => 'Admin'],
            ['id' => 29, 'nome' => 'Sra. Raquel Carvalho', 'email' => 'mariana71@farias.com', 'tipo' => 'Usuário'],
            ['id' => 30, 'nome' => 'Luigi Costa', 'email' => 'alicegoncalves@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 31, 'nome' => 'Sr. Kevin Dias', 'email' => 'mda-rocha@duarte.org', 'tipo' => 'Usuário'],
            ['id' => 32, 'nome' => 'Enrico Mendes', 'email' => 'nicolas43@campos.br', 'tipo' => 'Admin'],
            ['id' => 33, 'nome' => 'Luiz Felipe Santos', 'email' => 'aragaostephany@ribeiro.com', 'tipo' => 'Usuário'],
            ['id' => 34, 'nome' => 'Calebe Silva', 'email' => 'ryandas-neves@ramos.br', 'tipo' => 'Admin'],
            ['id' => 35, 'nome' => 'Dr. João Gabriel Freitas', 'email' => 'lrezende@carvalho.br', 'tipo' => 'Usuário'],
            ['id' => 36, 'nome' => 'Dra. Daniela Costa', 'email' => 'henrique05@ig.com.br', 'tipo' => 'Admin'],
            ['id' => 37, 'nome' => 'Dra. Carolina Duarte', 'email' => 'prodrigues@rocha.com', 'tipo' => 'Usuário'],
            ['id' => 38, 'nome' => 'Ryan Moreira', 'email' => 'silveiraenzo-gabriel@aragao.br', 'tipo' => 'Admin'],
            ['id' => 39, 'nome' => 'Marina Araújo', 'email' => 'eduarda85@uol.com.br', 'tipo' => 'Usuário'],
            ['id' => 40, 'nome' => 'Gabriela Lopes', 'email' => 'azevedolara@duarte.org', 'tipo' => 'Admin'],
            ['id' => 41, 'nome' => 'Diego Caldeira', 'email' => 'liviada-mata@moreira.br', 'tipo' => 'Usuário'],
            ['id' => 42, 'nome' => 'Sophie Almeida', 'email' => 'wlopes@moraes.com', 'tipo' => 'Admin'],
            ['id' => 43, 'nome' => 'Emanuelly da Rocha', 'email' => 'moreiragabriela@yahoo.com.br', 'tipo' => 'Usuário'],
            ['id' => 44, 'nome' => 'Pedro Lucas Cunha', 'email' => 'mendesjuliana@da.org', 'tipo' => 'Admin'],
            ['id' => 45, 'nome' => 'Rebeca Nascimento', 'email' => 'sarah88@correia.br', 'tipo' => 'Usuário'],
            ['id' => 46, 'nome' => 'Dr. Thiago Farias', 'email' => 'pauloda-mota@pires.org', 'tipo' => 'Admin'],
            ['id' => 47, 'nome' => 'Enrico Ramos', 'email' => 'maysapinto@moreira.br', 'tipo' => 'Usuário'],
            ['id' => 48, 'nome' => 'Ian Silva', 'email' => 'maria-vitoria33@vieira.org', 'tipo' => 'Admin'],
            ['id' => 49, 'nome' => 'Davi Moreira', 'email' => 'ipires@peixoto.br', 'tipo' => 'Usuário'],
            ['id' => 50, 'nome' => 'Larissa Pires', 'email' => 'ana-livia87@lima.com', 'tipo' => 'Admin'],
            ['id' => 51, 'nome' => 'Caio Costa', 'email' => 'carolineda-cruz@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 52, 'nome' => 'Paulo Rezende', 'email' => 'salescarolina@pinto.br', 'tipo' => 'Admin'],
            ['id' => 53, 'nome' => 'Cauã Costa', 'email' => 'eteixeira@hotmail.com', 'tipo' => 'Usuário'],
            ['id' => 54, 'nome' => 'Giovanna Sales', 'email' => 'ygoncalves@da.br', 'tipo' => 'Admin'],
            ['id' => 55, 'nome' => 'Luna Lima', 'email' => 'wcampos@hotmail.com', 'tipo' => 'Usuário'],
            ['id' => 56, 'nome' => 'Levi Costa', 'email' => 'felipecosta@lima.br', 'tipo' => 'Admin'],
            ['id' => 57, 'nome' => 'Lavínia Fogaça', 'email' => 'yasmin45@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 58, 'nome' => 'Pedro Henrique Costela', 'email' => 'joaoduarte@silva.com', 'tipo' => 'Admin'],
            ['id' => 59, 'nome' => 'Lucas da Rosa', 'email' => 'mariane39@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 60, 'nome' => 'Sra. Camila Duarte', 'email' => 'da-cunhasofia@gmail.com', 'tipo' => 'Admin'],
            ['id' => 61, 'nome' => 'Sr. João Felipe Pinto', 'email' => 'lucas-gabriel54@da.br', 'tipo' => 'Usuário'],
            ['id' => 62, 'nome' => 'Amanda Almeida', 'email' => 'ianalmeida@freitas.com', 'tipo' => 'Admin'],
            ['id' => 63, 'nome' => 'Srta. Gabrielly Barbosa', 'email' => 'carvalhoamanda@teixeira.com', 'tipo' => 'Usuário'],
            ['id' => 64, 'nome' => 'Dr. Lorenzo Correia', 'email' => 'sofia70@yahoo.com.br', 'tipo' => 'Admin'],
            ['id' => 65, 'nome' => 'Gabriela Lima', 'email' => 'naraujo@uol.com.br', 'tipo' => 'Usuário'],
            ['id' => 66, 'nome' => 'Sarah Pires', 'email' => 'kamilly28@campos.com', 'tipo' => 'Admin'],
            ['id' => 67, 'nome' => 'Srta. Isabella Cardoso', 'email' => 'barrosnoah@farias.com', 'tipo' => 'Usuário'],
            ['id' => 68, 'nome' => 'Bárbara Cardoso', 'email' => 'melissa12@monteiro.net', 'tipo' => 'Admin'],
            ['id' => 69, 'nome' => 'Marcela Fogaça', 'email' => 'thales10@yahoo.com.br', 'tipo' => 'Usuário'],
            ['id' => 70, 'nome' => 'Bruna Santos', 'email' => 'ana-clarafogaca@bol.com.br', 'tipo' => 'Admin'],
            ['id' => 71, 'nome' => 'Benício Ribeiro', 'email' => 'silvaemanuelly@hotmail.com', 'tipo' => 'Usuário'],
            ['id' => 72, 'nome' => 'Srta. Isadora Duarte', 'email' => 'ianda-mota@cardoso.net', 'tipo' => 'Admin'],
            ['id' => 73, 'nome' => 'Luigi Duarte', 'email' => 'luizagomes@yahoo.com.br', 'tipo' => 'Usuário'],
            ['id' => 74, 'nome' => 'Cauê Moura', 'email' => 'portolaura@silva.com', 'tipo' => 'Admin'],
            ['id' => 75, 'nome' => 'Olivia Gomes', 'email' => 'hmelo@moraes.com', 'tipo' => 'Usuário'],
            ['id' => 76, 'nome' => 'Milena Araújo', 'email' => 'lrocha@hotmail.com', 'tipo' => 'Admin'],
            ['id' => 77, 'nome' => 'Dr. Kaique Viana', 'email' => 'aragaorodrigo@hotmail.com', 'tipo' => 'Usuário'],
            ['id' => 78, 'nome' => 'Alexandre Fogaça', 'email' => 'gustavo-henrique61@moreira.org', 'tipo' => 'Admin'],
            ['id' => 79, 'nome' => 'Srta. Lara Ramos', 'email' => 'thomas07@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 80, 'nome' => 'Maria Alice Rodrigues', 'email' => 'freitasrafael@bol.com.br', 'tipo' => 'Admin'],
            ['id' => 81, 'nome' => 'Heitor da Rocha', 'email' => 'wnascimento@ig.com.br', 'tipo' => 'Usuário'],
            ['id' => 82, 'nome' => 'Brenda da Cunha', 'email' => 'enzo93@hotmail.com', 'tipo' => 'Admin'],
            ['id' => 83, 'nome' => 'Eloah Farias', 'email' => 'agathacosta@ferreira.br', 'tipo' => 'Usuário'],
            ['id' => 84, 'nome' => 'Lucas Carvalho', 'email' => 'joao-pedrogomes@pires.br', 'tipo' => 'Admin'],
            ['id' => 85, 'nome' => 'Vitor Moreira', 'email' => 'ribeirovitor-gabriel@da.org', 'tipo' => 'Usuário'],
            ['id' => 86, 'nome' => 'Marcos Vinicius Carvalho', 'email' => 'matheus86@bol.com.br', 'tipo' => 'Admin'],
            ['id' => 87, 'nome' => 'João Vitor Peixoto', 'email' => 'marianeda-rocha@hotmail.com', 'tipo' => 'Usuário'],
            ['id' => 88, 'nome' => 'João Felipe da Costa', 'email' => 'emanuellada-paz@fernandes.br', 'tipo' => 'Admin'],
            ['id' => 89, 'nome' => 'Maria Cecília Cunha', 'email' => 'correiaheloisa@da.org', 'tipo' => 'Usuário'],
            ['id' => 90, 'nome' => 'Augusto Pires', 'email' => 'tnunes@moura.com', 'tipo' => 'Admin'],
            ['id' => 91, 'nome' => 'Evelyn Moura', 'email' => 'melissa15@da.net', 'tipo' => 'Usuário'],
            ['id' => 92, 'nome' => 'Davi Barros', 'email' => 'otavio32@viana.net', 'tipo' => 'Admin'],
            ['id' => 93, 'nome' => 'Sra. Luiza Almeida', 'email' => 'larissa75@gmail.com', 'tipo' => 'Usuário'],
            ['id' => 94, 'nome' => 'Mariane Silva', 'email' => 'souzagabrielly@uol.com.br', 'tipo' => 'Admin'],
            ['id' => 95, 'nome' => 'Marcelo Viana', 'email' => 'nogueiraana-clara@bol.com.br', 'tipo' => 'Usuário'],
            ['id' => 96, 'nome' => 'Daniel Rocha', 'email' => 'alice27@barros.br', 'tipo' => 'Admin'],
            ['id' => 97, 'nome' => 'Isabella Ramos', 'email' => 'mmartins@das.com', 'tipo' => 'Usuário'],
            ['id' => 98, 'nome' => 'Marcela Duarte', 'email' => 'isis81@alves.br', 'tipo' => 'Admin'],
            ['id' => 99, 'nome' => 'Renan da Rocha', 'email' => 'foliveira@hotmail.com', 'tipo' => 'Usuário'],
            ['id' => 100, 'nome' => 'Maria Julia Santos', 'email' => 'nramos@gmail.com', 'tipo' => 'Admin']
        ];

        return json_encode($users);
    }

   
}
