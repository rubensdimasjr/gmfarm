# GMFARM

### 🚀 Projeto da Startup de TI - Uniceplac, SISTEMA DE GESTÃO DE MATERIAIS DE FARMÁCIA

<div align="center"><a href="https://github.com/rubensdimasjr/gmfarm/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/rubensdimasjr/gmfarm"></a>&nbsp<a href="https://github.com/rubensdimasjr/gmfarm/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/rubensdimasjr/gmfarm"></a>&nbsp<a href="https://github.com/rubensdimasjr/gmfarm/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/rubensdimasjr/gmfarm"></a>&nbsp<img src="https://img.shields.io/badge/status-in%20progress-blue?style=social&logo=appveyor"></div>

### 👨‍💻 Tecnologias Utilizadas

<ul>
<li><a href="https://www.php.net/">PHP</a></li>
<li><a href="https://www.mysql.com/">MySQL</a></li>
<li><a href="https://getbootstrap.com/">Bootstrap 5</a></li>
<li><a href="https://jquery.com/">Javascript, jQuery</a></li>
</ul>

### ⛲ Features

- [x] Cadastro de Materiai
- [x] Alteração de materiais
- [x] Exclusão de materiais
- [x] Login de Usuário
- [x] Tratramento de Sessão
- [x] Calculadora de Receita
- [x] Relatório
- [x] Pacientes

### 🌍 Preparação de Ambiente

- Precisa estar instalado no seu Ambiente: [XAMPP](https://www.apachefriends.org/pt_br/index.html) ou <b>PHP, Apache e MySQL</b> separados.
- Foi utilizado o <b>phpMyAdmin</b> como interface gráfica para o banco (utilize conforme sua preferência).
- <b>[Git](https://git-scm.com/)</b> para o versionamento do projeto.
- <b>Composer</b> para gerenciamento de dependências (<b>[Instalação aqui](https://getcomposer.org/download/)</b>).

#### Começando

```bash
# Clone o repositório ou Faça Download do ZIP 
$ git clone https://github.com/rubensdimasjr/gmfarm.git
```

#### Download ZIP

<a href="https://github.com/rubensdimasjr/gmfarm/archive/refs/heads/main.zip">
  <button type="button">GMFARM.ZIP</button>
</a>

<hr />

#### Importando o banco(SQL) no phpMyAdmin (ou qualquer interface gráfica)

1. Com o **XAMPP** ligado (ou seu servidor PHP), Realize Login no phpMyAdmin (localhost/phpmyadmin)

![Captura de tela de 2022-05-23 11-16-03](https://user-images.githubusercontent.com/33848110/169839785-5d8ade5a-97c0-4f56-b454-699646cb1d56.png)

2. Crie um novo banco chamado **"gmfarm"**

![Captura de tela de 2022-05-23 11-18-35](https://user-images.githubusercontent.com/33848110/169840357-595d1cbb-29dd-4986-9091-d2bd3ee5cd1e.png)

3. Dentro de **gmfarm** > **Importar**

![Captura de tela de 2022-05-23 11-23-25](https://user-images.githubusercontent.com/33848110/169841359-e3428670-8f55-4938-8276-de0ecbae7216.png)

4. Escolha o arquivo > **gmfarm.sql** > dentro do repositório > **gmfarm-main** > ou acesse [link](https://github.com/rubensdimasjr/gmfarm/blob/main/gmfarm.sql)

<hr />

#### Adicionando as dependências do projeto (Após instalação do **Composer**)

1. Utilizando um terminal (git bash ou cmd) dentro da pasta **gmfarm-main** > execute o comando: *composer install* *composer dump-autoload -o* (para instalar as depedências e atualizá-las)

<hr />

#### Alterando as variáveis de ambiente

1. Acesse seu editor de código com o repositório do projeto > vá até > **.env.example** > copie o arquivo e crie um **.env** > altere os dados e acesse sua **URL**.

![Captura de tela de 2022-05-23 14-34-16](https://user-images.githubusercontent.com/33848110/169875788-b76693e9-9a26-41e5-8828-0e8de3ca8b9d.png)
