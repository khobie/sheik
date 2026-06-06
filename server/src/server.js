import cors from 'cors';
import dotenv from 'dotenv';
import express from 'express';
import helmet from 'helmet';
import morgan from 'morgan';
import { checkDatabaseConnection } from './config/database.js';
import { apiRoutes } from './routes/apiRoutes.js';

dotenv.config();

const app = express();
const port = process.env.PORT || 4000;
const clientOrigin = process.env.CLIENT_ORIGIN || 'http://localhost:5173';

app.use(helmet());
app.use(cors({ origin: clientOrigin }));
app.use(express.json({ limit: '1mb' }));
app.use(morgan(process.env.NODE_ENV === 'production' ? 'combined' : 'dev'));

app.get('/', (req, res) => {
  res.json({
    name: 'Koforidua Artisan Booking API',
    status: 'running',
    documentation: '/api/health',
  });
});

app.get('/api/database/health', async (req, res) => {
  const status = await checkDatabaseConnection();
  res.status(status.healthy ? 200 : 503).json(status);
});

app.use('/api', apiRoutes);

app.use((req, res) => {
  res.status(404).json({ error: 'Route not found' });
});

app.use((error, req, res, next) => {
  const statusCode = error.statusCode || 500;
  res.status(statusCode).json({
    error: error.message || 'Internal server error',
  });
});

app.listen(port, () => {
  console.log(`Artisan booking API listening on http://localhost:${port}`);
});
