import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    allowedHosts: ['1da9c0a2555a964a75d2-pod-66g365awczcyxeiejxxvhfft3y-5173.us6.cursorvm.com'],
  },
})
