# LTW
## Projeto

Este projeto foi desenvolvido no âmbito da unidade curricular "Linguagens e Tecnologias Web" do 3º do Mestrado Integrado em Engenharia Informática e Computação da Faculdade de Engenharia da Universidade do Porto.

O objetivo era o de produzir um website de gestão de eventos onde fosse possível: 
- Registo de utilizadores em contas privadas
- Possibilidade de login e logout do sistema
- Utilizadores registados devem poder criar eventos
- Utilizadores registados devem poder gerir os seus eventos (editar, apagar, ...).
- Eventos devem conter uma imagem, data, descrição e tipo.
- Utilizadores devem poder pesquisar eventos e registar em eventos.
- Utilizadores não devem poder registar-se duas vezes no mesmo evento.
- Donos de eventos e utilziadores registados no evento devem poder adicionar comentários a esse evento.
- Devem ser utilizadas as seguintes tecnologias: HTML, CSS, PHP, Javascript (jQuery), Ajax/JSON, PDO/SQL (sqlite).
- O site deve ser o mais seguro possível
- O código deve ser organizado e consistente.

Para além disso, foram adicionadas as seguintes funcionalidades:
- Possibilidade de criar eventos públicos ou privados, sendo que no caso de serem privados só os utilizadores convidados conseguem ver o evento.
- Possibilidade de o dono do evento alterar a "privacidade" do evento.
- Proteção contra XSS, CSRF, SQL injection e session fixation.
- Pesquisa com "full text search" para pesquisar eventos a que o utilizador tenha acesso.
- Possibilidade de o dono de um evento o editar de forma "inline".
- Implementação de um sistema de respostas que permite criar dois níveis de comentário: um primeiro nível de comentários ao evento em si, e um segundo nível para respostas aos comentários de primeiro nível.
- Validação de campos preenchidos por utilizador com expressões regulares.
- Possibilidade de partilhar o link para um evento no Facebook.
