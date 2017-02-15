Operation manual
=================

# Configuration

You need to set some environment variables in order to configure the CRA daemon, such as in the following example:

* `IDOS_VERSION`: indicates the version of idOS API to use (default: '1.0');
* `IDOS_DEBUG`: indicates whether to enable debugging (default: false);
* `IDOS_LOG_FILE`: is the path for the generated log file (default: 'log/cra.log');
* `IDOS_GEARMAN_SERVERS`: a list of gearman servers that the daemon will register on (default: 'localhost:4730');
* `IDOS_CRA_TRACESMART_ENDPOINT`: the URL for the TraceSmart API endpoint (default: 'https://iduws.tracesmart.co.uk/v3.3/?wsdl').

# Running

In order to start the CRA daemon you should run in the terminal:

```
./cra-cli.php cra:daemon [-d] [-l path/to/log/file] handlerPublicKey handlerPrivateKey functionName serverList
```

* `handlerPublicKey`: public key of the handler registered within idOS
* `handlerPrivateKey`: private key of the handler registered within idOS
* `functionName`: gearman function name
* `serverList`: a list of the gearman servers
* `-d`: enable debug mode
* `-l`: the path for the log file

Example:

```
./cra-cli.php cra:daemon -d -l log/cra.log ef970ffad1f1253a2182a88667233991 213b83392b80ee98c8eb2a9fed9bb84d cra localhost
```