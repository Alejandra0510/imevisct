const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require("copy-webpack-plugin");

const isProduction = process.env.NODE_ENV == 'production';

const apacheServerAddress = 'http://localhost/imevisct';

const stylesHandler = isProduction ? MiniCssExtractPlugin.loader : 'style-loader';

module.exports = {
    mode: 'development',
    entry: {
        main:     './src/index.js',
        login:    './src/js/components/login.js',
        business: './src/js/components/business.js',
        account:  './src/js/components/sys/account.js',
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
    },
    devServer: {
        proxy: {
            '/': {
                target: apacheServerAddress,
                changeOrigin: true,
                secure: false
            }
        }
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
        new CopyPlugin({
            patterns: [
                { from: "src/assets", to: "assets/" }
            ]
        })
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
                use: [stylesHandler,'css-loader'],
            },
            {
                test: /\.(eot|svg|ttf|woff|woff2|png|jpg|gif)$/i,
                type: 'asset',
            },
        ]
    },
}