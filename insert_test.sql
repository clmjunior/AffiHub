-- País
INSERT INTO L001 (L001_Name, L001_Abbreviation) VALUES
('Brasil', 'BR');

-- Estado
INSERT INTO L002 (L002_L001_Id, L002_Name, L002_UF) VALUES
(1, 'Paraná', 'PR');

-- Cidade
INSERT INTO L003 (L003_L002_Id, L003_Name) VALUES
(1, 'Curitiba');

-- Endereço
INSERT INTO L004 (L004_Street, L004_Number, L004_Complement, L004_District, L004_ZipCode, L004_L003_Id) VALUES
('Av. Sete de Setembro', '1234', 'Sala 10', 'Centro', '80000-000', 1);

-- Empresa
INSERT INTO C001 (
    C001_L004_Id, C001_Company_Name, C001_Trade_Name, C001_Short_Name,
    C001_State_Registration, C001_Secondary_State_Registration,
    C001_Municipal_Registration, C001_CNAE, C001_Tax_Regime_Code,
    C001_CNPJ, C001_Phone, C001_Whatsapp, C001_Website, C001_Logo
) VALUES (
    1, 'Exemplo Ltda', 'Exemplo Store', 'Exemplo',
    '123456789', '987654321',
    '1122334455', '4791001', 3,
    '12.345.678/0001-90', '(41)99999-9999', '(41)98888-8888', 'https://exemplo.com.br', 'logo.png'
);

-- Categoria
INSERT INTO C002 (C002_Name, C002_Description) VALUES
('Informática', 'Produtos relacionados a computadores e acessórios');

-- Produto
INSERT INTO P001 (
    P001_C001_Id, P001_C002_Id, P001_EAN, P001_Name, P001_Title,
    P001_Description, P001_Brand, P001_Weight,
    P001_Height, P001_Width, P001_Length, P001_Is_Active
) VALUES (
    1, 1, '7891234567890', 'Notebook Dell Inspiron 15', 'Dell Inspiron 15',
    'Notebook com processador Intel i5, 8GB RAM, 256GB SSD', 'Dell', 1900.00,
    2.00, 35.00, 25.00, TRUE
);

-- Marketplace
INSERT INTO M001 (M001_Name, M001_Api_Url, M001_Is_Active) VALUES
('Mercado Livre', 'https://api.mercadolibre.com', TRUE);

-- Anúncio
INSERT INTO P002 (
    P002_M001_Id, P002_P001_Id, P002_Internal_Code,
    P002_Title, P002_Price, P002_Stock, P002_Status
) VALUES (
    1, 1, 'INT-DLL-001',
    'Notebook Dell i5 8GB 256GB SSD', 3499.90, 10, 'ativo'
);

-- Imagem do Produto
INSERT INTO I001 (I001_P001_Id, I001_File, I001_Order) VALUES
(1, 'notebook-dell.jpg', 1);

-- Usuário
INSERT INTO U001 (U001_Name, U001_CPF, U001_Email, U001_Password) VALUES
('Administrador', '123.456.789-00', 'admin@exemplo.com', SHA2('senha123', 256));

-- Credenciais de API (vinculadas ao usuário e empresa acima)
INSERT INTO S001 (
    S001_U001_Id, S001_C001_Id, S001_Api_Key,
    S001_Api_Secret, S001_Access_Token, S001_Token_Expiry
) VALUES (
    1, 1, 'api_key_exemplo', 'api_secret_exemplo', 'access_token_exemplo', NOW() + INTERVAL 7 DAY
);
