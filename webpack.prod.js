const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require("copy-webpack-plugin");

const CssMinimizer = require("css-minimizer-webpack-plugin");
const Terser = require("terser-webpack-plugin");

module.exports = {
    mode: 'production',
    entry: {
        main:            './src/index.js',
        login:           './src/js/components/login.js',
        business:        './src/js/components/business.js',
        account:         './src/js/components/sys/account.js',
        role:            './src/js/components/admin/roles.js',
        rolem:           './src/js/components/admin/roles.magnament.js',
        user:            './src/js/components/admin/usuarios.js',
        userm:           './src/js/components/admin/usuarios.magnament.js',
        citizen:         './src/js/components/catalogos/ciudadanos.js',
        citizenm:        './src/js/components/catalogos/ciudadanos.magnament.js',
        streets:         './src/js/components/catalogos/calles.js',
        steetsm:         './src/js/components/catalogos/calles.magnament.js',
        communities:     './src/js/components/catalogos/comunidades.js',
        communitiesm:    './src/js/components/catalogos/comunidades.magnament.js',
        documents:       './src/js/components/catalogos/documentos.js',
        documentsm:      './src/js/components/catalogos/documentos.magnament.js',
        ids:             './src/js/components/catalogos/identificacion.js',
        idsm:            './src/js/components/catalogos/identificacion.magnament.js',
        modality:        './src/js/components/catalogos/modalidad.js',
        modalitym:       './src/js/components/catalogos/modalidad.magnament.js',
        directions:      './src/js/components/catalogos/rumbos.js',
        directionsm:     './src/js/components/catalogos/rumbos.magnament.js'
    },
    output: {
        path: __dirname + '/build',
        clean: true,
        filename: "[name][contenthash].bundle.js",
        publicPath: "dist/"
    },
    optimization: {
        minimize: true,
        minimizer: [
            new CssMinimizer(),
            new Terser(),
        ]
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: './src/index.html',
            filename: './inc/headercommon.php',
            inject: 'body',
            chunks: [
                'main'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/login.php',
            inject: 'body',
            chunks: [
                'login'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/business.php',
            inject: 'body',
            chunks: [
                'business'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/account.php',
            inject: 'body',
            chunks: [
                'account'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/roles.php',
            inject: 'body',
            chunks: [
                'role'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/roles.magnament.php',
            inject: 'body',
            chunks: [
                'rolem'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/usuarios.php',
            inject: 'body',
            chunks: [
                'user'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/usuarios.magnament.php',
            inject: 'body',
            chunks: [
                'userm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/ciudadanos.php',
            inject: 'body',
            chunks: [
                'citizen'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/ciudadanos.magnament.php',
            inject: 'body',
            chunks: [
                'citizenm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/calles.php',
            inject: 'body',
            chunks: [
                'streets'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/calles.magnament.php',
            inject: 'body',
            chunks: [
                'steetsm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/comunidades.php',
            inject: 'body',
            chunks: [
                'communities'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/comunidades.magnament.php',
            inject: 'body',
            chunks: [
                'communitiesm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/documentos.php',
            inject: 'body',
            chunks: [
                'documents'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/documentos.magnament.php',
            inject: 'body',
            chunks: [
                'documentsm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/identificacion.php',
            inject: 'body',
            chunks: [
                'ids'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/identificacion.magnament.php',
            inject: 'body',
            chunks: [
                'idsm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/modalidad.php',
            inject: 'body',
            chunks: [
                'directions'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/modalidad.magnament.php',
            inject: 'body',
            chunks: [
                'directionsm'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/rumbos.php',
            inject: 'body',
            chunks: [
                'ids'
            ]
        }),
        new HtmlWebpackPlugin({
            template: './src/nocontent.html',
            filename: './components/rumbos.magnament.php',
            inject: 'body',
            chunks: [
                'idsm'
            ]
        }),
        new CopyPlugin({
            patterns: [
                { from: "src/assets", to: "assets/" }
            ]
        }),
    ],
    module: {
        rules: [
            {
                test: /\.css$/,
                exclude: /styles\.css$/,
                use: [
                    'style-loader',
                    'css-loader'
                ]
            },
            {
                test: /\.(js|jsx)$/i,
                loader: 'babel-loader',
            },
            {
                test: /styles\.css$/,
                use: [MiniCssExtractPlugin.loader,'css-loader'],
            },
            {
                test: /\.html$/i,
                loader: 'html-loader',
                options: {
                    sources: false,
                }
            },
            {
                test: /\.(png|svg|jpe?g|gif)$/,
                loader: 'file-loader'
            },
        ]
    }
}