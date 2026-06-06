import mysql from 'mysql2/promise';

const {
  DB_HOST,
  DB_PORT = '3306',
  DB_USER,
  DB_PASSWORD,
  DB_NAME,
} = process.env;

export const isDatabaseConfigured = Boolean(DB_HOST && DB_USER && DB_NAME);

export const pool = isDatabaseConfigured
  ? mysql.createPool({
      host: DB_HOST,
      port: Number(DB_PORT),
      user: DB_USER,
      password: DB_PASSWORD,
      database: DB_NAME,
      waitForConnections: true,
      connectionLimit: 10,
      namedPlaceholders: true,
    })
  : null;

export async function checkDatabaseConnection() {
  if (!pool) {
    return { configured: false, healthy: false, message: 'MySQL environment variables are not configured.' };
  }

  try {
    await pool.query('SELECT 1');
    return { configured: true, healthy: true, message: 'MySQL connection is healthy.' };
  } catch (error) {
    return { configured: true, healthy: false, message: error.message };
  }
}
