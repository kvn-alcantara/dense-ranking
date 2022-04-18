# Desafio Cygni - Dense Ranking

Criar uma API em PHP com Laravel para SPA , onde o administrador do sistema poderá cadastrar uma lista de scores para determinado jogo. Os jogadores poderão se cadastrar, inserir seu score e consultar o rank.

Sempre que um jogador cadastrar um novo score, o sistema deve utilizar dense ranking para determinar qual a nova posição dos jogadores.

De maneira simples:
Se as os scores já cadastrados forem: [90, 70, 70, 40, 10] a posição de cada score é [1,2,2,3,4]. O dois se repete por ter dois scores com o mesmo valor na segunda posição.
Se alguém se cadastrar com o score 5, ele será o 5 colocado. -> Scores = [90, 70, 70, 40, 10, 5] Posições = [1, 2, 2, 3, 4, 5]
Se alguém se cadastrar com score 70, ele será o 2 colocado. -> Scores = [90, 70, 70, 70 40, 10, 5] Posições = [1, 2, 2, 2, 3, 4, 5]
Se alguém se cadastrar com score 100, ele será o 1 colocado -> Scores = [100, 90, 70, 70, 70, 40, 10, 5] Posições = [1, 2, 3, 3, 3, 4, 5, 6]

A função que ajusta os scores e define a lista de posições deve estar devidamente documentada.

O projeto deve ser disponibilizado em qualquer plataforma git (GitHub, Bitbucket, etc) e devidamente documentado, de forma que o avaliador possa instalá-lo e testá-lo.
