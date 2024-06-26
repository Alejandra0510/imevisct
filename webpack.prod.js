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