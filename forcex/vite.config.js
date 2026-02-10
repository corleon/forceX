const { defineConfig } = require('vite')
const { resolve } = require('path')

module.exports = defineConfig({
  root: '.',
  base: './',
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/main.js')
      },
      output: {
        entryFileNames: '[name].[hash].js',
        chunkFileNames: '[name].[hash].js',
        assetFileNames: '[name].[hash].[ext]'
      }
    },
    manifest: true,
    emptyOutDir: true
  },
  server: {
    host: 'localhost',
    port: 5173,
    cors: true,
    hmr: {
      host: 'localhost'
    }
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src')
    }
  }
})
