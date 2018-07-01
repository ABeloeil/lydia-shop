const path = require('path');

module.exports = {
  mode: 'development',
  entry: './app/Resources/js/shop.js',
  devtool: 'source-map',
  watch: true,
  output: {
    filename: 'shop.js',
    path: path.resolve(__dirname, 'web', 'js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: ['babel-loader'],
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
      {
        test: /\.(jpe?g|gif|png|svg|woff|ttf|wav|mp3|eot|woff2)$/,
        use: 'file-loader',
      },
    ]
  }
}
