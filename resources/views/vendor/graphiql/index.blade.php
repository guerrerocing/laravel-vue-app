<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=utf-8/>
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, minimal-ui">
    <title>GraphiQL</title>
    <style>
        body {
            height: 100%;
            margin: 0;
            width: 100%;
            overflow: hidden;
        }

        #graphiql {
            height: 100vh;
        }
    </style>
    <script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::reactPath() }}"></script>
    <script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::reactDOMPath() }}"></script>
    <link rel="stylesheet" href="{{ \MLL\GraphiQL\DownloadAssetsCommand::cssPath() }}"/>
    <link rel="shortcut icon" href="{{ \MLL\GraphiQL\DownloadAssetsCommand::faviconPath() }}"/>
</head>

<body>

<div id="graphiql">Loading...</div>
<script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::jsPath() }}"></script>
@php

    $query = /* @lang GraphQL */ <<<GRAPHQL
    query shopsWithStock {
        shopsWithStock(first: 10){
        edges{
          node{
            id
            name
            description
            address
            products(first: 10){
              edges{
                node{
                  id
                  name
                }
              }
            }
          }
        }
    }
    }
    query shopsWithOutStock {
        shopsWithOutStock(first: 10){
            edges{
              node{
                id
                name
                description
                address
                products(first: 10){
                  edges{
                    node{
                      id
                      name
                      description
                      discount
                      price
                    }
                  }
                }
              }
            }
        }
    }
    GRAPHQL;
@endphp
<script>
    ReactDOM.render(
        React.createElement(GraphiQL, {
            query: {!! json_encode($query) !!},
            fetcher: GraphiQL.createFetcher({
                url: '{{ url(config('graphiql.endpoint')) }}',
                subscriptionUrl: '{{ config('graphiql.subscription-endpoint') }}',
            }),

        }),
        document.getElementById('graphiql'),
    );
</script>

</body>
</html>
