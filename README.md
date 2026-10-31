# IOT-ETEC — Cadastro e consulta de alunos por cartão RFID

Sistema web feito na **ETEC de Cotia** ("Sistema Integrado ETEC de Cotia") que identifica alunos
pelo **cartão/chaveiro RFID**. Um **NodeMCU ESP8266** com leitor **RC522** lê o UID do cartão e manda
para um servidor **PHP + MySQL**, onde dá para **cadastrar** o aluno ligado àquele cartão, **listar**
todos no fichário, **editar**, **excluir** e **consultar** quem é o dono do cartão só aproximando-o
do leitor.

Baseado no projeto aberto *NodeMCU and RFID RC522 IoT Projects* (The IoT Projects), traduzido e
adaptado para o contexto da escola.

---

## Sumário

- [Como funciona](#como-funciona)
- [Hardware](#hardware)
- [Ligação NodeMCU ↔ RC522](#ligação-nodemcu--rc522)
- [Telas](#telas)
- [Estrutura do repositório](#estrutura-do-repositório)
- [Banco de dados](#banco-de-dados)
- [Instalação passo a passo](#instalação-passo-a-passo)
- [Problemas comuns](#problemas-comuns)
- [Limitações e próximos passos](#limitações-e-próximos-passos)

---

## Como funciona

```
 Cartão RFID ─▶ RC522 ─SPI─▶ NodeMCU ESP8266 ──Wi-Fi / HTTP POST──▶ getUID.php
                                                 UIDresult=39EAB06D      │
                                                                         ▼ grava
                                                                  UIDContainer.php
                                                                         ▲ lê a cada 0,5–1 s (jQuery .load)
                                                   cadastro.php / consulta.php no navegador
                                                                         │
                                                                         ▼
                                                    MySQL: nodemcu_rfid_iot_projects
```

1. O NodeMCU conecta no Wi-Fi e fica lendo o RC522 (`getid()`); o UID de 4 bytes vira texto
   hexadecimal (ex.: `39EAB06D`).
2. A cada leitura, faz `POST` de `UIDresult=<UID>` para `getUID.php` e pisca o LED da placa.
3. `getUID.php` reescreve o arquivo `UIDContainer.php` com o último UID lido.
4. As páginas **Cadastro** e **Consulta** recarregam `UIDContainer.php` em intervalos curtos — o UID
   aparece sozinho na tela, sem digitar.
5. No **Cadastro** o aluno é gravado com o UID como chave; na **Consulta** o sistema busca os dados
   do dono do cartão (`read tag user data.php`).

---

## Hardware

| Peça | Observação |
|------|------------|
| NodeMCU V3 (ESP8266 / ESP-12E) | placa Wi-Fi que roda o sketch |
| Leitor RFID **MFRC522 / RC522** (13,56 MHz) | alimentado em **3,3 V** |
| Cartões ou chaveiros MIFARE | um por aluno |
| Cabos jumper + cabo micro-USB | gravação e alimentação |
| PC/servidor com Apache + PHP + MySQL | XAMPP serve |

---

## Ligação NodeMCU ↔ RC522

| NodeMCU | RC522 |
|---------|-------|
| D2 | SDA/SS |
| D5 | SCK |
| D7 | MOSI |
| D6 | MISO |
| D1 | RST |
| GND | GND |
| 3V3 | 3.3V |

> Não ligue o RC522 em 5 V.

---

## Telas

Menu comum: **Página Inicial · Fichário · Cadastro · Consulta** (Bootstrap 2 + jQuery).

| Página | Arquivo | Função |
|--------|---------|--------|
| Página Inicial | `home.php` | Boas-vindas do "Sistema Integrado ETEC de Cotia" |
| Cadastro | `cadastro.php` → `insertDB.php` | "Passe o cartão no leitor": o campo **ID** é preenchido com o UID lido; completa nome, sexo, e-mail, celular e curso e grava |
| Fichário | `fichario.php` | Tabela de alunos em ordem de nome, com botões **Edit** e **Delete** |
| Editar | `user data edit page.php` → `user data edit tb.php` | Altera nome, sexo, e-mail e celular (o ID fica só leitura) |
| Excluir | `user data delete page.php` | Confirma e apaga o aluno |
| Consulta | `consulta.php` + `read tag user data.php` | Texto piscando "Passe o cartão no Leitor"; ao ler, mostra os dados do dono do cartão (ou avisa se o cartão não está cadastrado) |

---

## Estrutura do repositório

```
IOT-ETEC/
└── IOT-ETEC/
    ├── NodeMCU-and-RFID-RC522-IoT-Projects.ino   # sketch do NodeMCU (Wi-Fi + RC522 + HTTP POST)
    ├── nodemcu_rfid_iot_projects.sql             # dump do banco (tabela + 4 registros de exemplo)
    ├── database.php                              # classe Database (PDO, conexão única)
    ├── getUID.php                                # recebe o UID do NodeMCU
    ├── UIDContainer.php                          # "caixa" com o último UID (reescrita a cada leitura)
    ├── home.php · cadastro.php · fichario.php · consulta.php
    ├── insertDB.php                              # INSERT do cadastro
    ├── read tag user data.php                    # SELECT do dono do cartão (consulta)
    ├── user data edit page.php · user data edit tb.php   # edição
    ├── user data delete page.php                 # exclusão
    ├── css/ · js/                                # Bootstrap 2 e jQuery
    └── img/                                      # logos ETEC, Centro Paula Souza, etc.
```

---

## Banco de dados

Banco `nodemcu_rfid_iot_projects`, tabela única:

| Coluna | Tipo | Observação |
|--------|------|------------|
| `id` | varchar(100) | **chave primária** = UID do cartão |
| `name` | varchar(100) | nome do aluno |
| `gender` | varchar(100) | `Male` / `Female` |
| `email` | varchar(100) | |
| `mobile` | varchar(100) | celular |

---

## Instalação passo a passo

### 1. Servidor

1. Instale o XAMPP (ou Apache + PHP + MySQL/MariaDB).
2. Copie a pasta `IOT-ETEC/IOT-ETEC` para `htdocs/` com o nome que o sketch usa
   (`NodeMCU-and-RFID-RC522-IoT-Projects`) **ou** ajuste a URL no sketch (passo 2.4).
3. Importe o banco: `mysql -u root -p < nodemcu_rfid_iot_projects.sql` (ou pelo phpMyAdmin). O dump não
   tem `CREATE DATABASE` — crie o banco `nodemcu_rfid_iot_projects` antes.
4. Em `database.php`, ajuste `$dbHost`, `$dbUsername` e `$dbUserPassword` para um usuário do seu MySQL.
5. Dê permissão de escrita na pasta para o usuário do Apache (o `getUID.php` reescreve `UIDContainer.php`).
6. Descubra o IP do servidor na rede (`ipconfig`/`ip a`) e libere a porta 80 no firewall.

### 2. NodeMCU

1. Na Arduino IDE, adicione a placa **ESP8266** (Gerenciador de Placas) e selecione *NodeMCU 1.0 (ESP-12E)*.
2. Instale a biblioteca **MFRC522** (miguelbalboa/rfid).
3. Abra `NodeMCU-and-RFID-RC522-IoT-Projects.ino`.
4. Altere `ssid`, `password` e a URL em `http.begin("http://<IP-do-servidor>/<pasta>/getUID.php")`.
5. Grave na placa e abra o Monitor Serial em **115200**: deve aparecer o IP obtido e
   "Por favor escaneie um cartão…". Cada leitura mostra o UID, o código HTTP (200) e a resposta.

### 3. Uso

Abra `http://<IP-do-servidor>/<pasta>/home.php`, vá em **Cadastro**, aproxime o cartão e preencha o
restante. Depois teste em **Consulta**.

---

## Problemas comuns

| Sintoma | Causa provável |
|---------|----------------|
| Monitor serial fica em `Connecting....` | SSID/senha errados ou rede 5 GHz (o ESP8266 só usa 2,4 GHz) |
| UID aparece no serial mas não na tela | URL do `http.begin` errada, firewall do servidor ou `UIDContainer.php` sem permissão de escrita |
| HTTP code `-1` no serial | servidor inacessível pelo IP informado |
| Leitor não reage | ligação SPI trocada (confira a tabela) ou RC522 em 5 V |
| `SQLSTATE[HY000] [1045]` na página | usuário/senha do `database.php` |

---

## Limitações e próximos passos

- O campo **Curso** existe no formulário de cadastro, mas `insertDB.php` não grava (a tabela não tem a coluna).
- Só existe **um** "último UID" global: dois leitores ou duas pessoas usando a tela ao mesmo tempo se misturam.
- Não há login nem registro de **entrada/saída com horário** — a ideia original de controle de
  frequência (horário de entrada, intervalo, faltas automáticas) ainda não foi implementada; seria uma
  tabela `acessos (id_cartao, data_hora, tipo)` gravada pelo `getUID.php`.
- Credenciais de Wi-Fi e banco ficam no próprio código: troque pelos seus valores e não publique os reais.
- Arquivos com espaço no nome (`user data edit page.php`…) funcionam, mas exigem `%20` na URL.

---

Projeto escolar — ETEC de Cotia / Centro Paula Souza.
Autor do fork: [Luiz-DevBack](https://github.com/Luiz-DevBack)
