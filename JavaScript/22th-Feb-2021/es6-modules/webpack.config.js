const webpack = require('webpack');
const nodeENV = process.env.NODE_ENV || 'production';
module.exports = {
    mode: process.env.NODE_ENV || 'production',
    devtool: 'source-map',
    entry: {
        filename: './app.js',
    },
    output: {
      filename: 'build/bundle.js',
    },
    module = {
        loaders = [
            {
                test: /\.js$/,
                exclude: /node-modules/,
                loader = 'babel',
                query: {
                    presets = ['es2015-native-modules']
                }
            }
        ]
    },
    plugins: [
        //uglify js
        new webpack.optimize.UglifyJsPlugin({
            compress: { warning:false },
            output: { warning:false },
            sourceMap: true
        }),
        //env js
        new webpack.DefinePlugin({
            'process.env': {NODE_ENV: JSON.stringify(nodeENV)} 
        })

    ]
  };