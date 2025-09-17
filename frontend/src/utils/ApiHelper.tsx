import axios from 'axios';

const backendUrl: string = import.meta.env.VITE_BACKEND_URL || '';

const BACKEND_USERNAME: string = import.meta.env.VITE_USERNAME || '';
const BACKEND_PASSWORD: string = import.meta.env.VITE_PASSWORD || '';

// pending auth promise to dedupe concurrent authenticate() calls
let pendingAuthPromise: Promise<string | null> | null = null;

/**
 * Read token from localStorage. If not present, try to authenticate and then re-read.
 * Deduplicates concurrent authenticate calls.
 */
const getStoredToken = async (): Promise<string | null> => {
  try {
    const token = localStorage.getItem('auth_token');
    if (token) return token;

    if (!pendingAuthPromise) {
      pendingAuthPromise = (async () => {
        try {
          return await authenticate();
        } finally {
          // clear the pending promise so future auths can run if needed
          pendingAuthPromise = null;
        }
      })();
    }

    return await pendingAuthPromise;
  } catch {
    return null;
  }
};

/**
 * Authenticate (POST /api/authenticate)
 * - uses BACKEND_USERNAME and BACKEND_PASSWORD environment variables by default
 * - stores returned token in localStorage under 'auth_token'
 * - returns the axios response
 */
export const authenticate = async () => {
  const url = `${backendUrl.replace(/\/+$/, '')}/api/authenticate`;

  const payload = {
    email: BACKEND_USERNAME,
    password: BACKEND_PASSWORD,
  };

  try {
    const res = await axios.post(url, payload, {
      headers: { 'Content-Type': 'application/json' },
    });

    const token = res?.data?.data?.token;
    console.log('Authenticated, received token:', token);
    if (token) {
      localStorage.setItem('auth_token', String(token));
    }

    return token;
  } catch (error) {
    // rethrow so callers can handle
    throw error;
  }
};

/**
 * Generic API helper
 * - reads token from localStorage (and authenticates if needed)
 * - sets Authorization header if token present
 */
const ApiHelper = async <T = any>(
  url: string,
  method: string,
  body?: any,
) => {
  const token = await getStoredToken();
  // console.log('Using token:', token);

  const normalizedUrl = `${backendUrl.replace(/\/+$/, '')}/api/v1/${String(url).replace(/^\/+/, '')}`;

  let config: any = {
    method,
    url: normalizedUrl,
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
  };

  // place payload for methods that support a body
  const methodLower = (method || 'get').toString().toLowerCase();
  if (['post', 'put', 'patch'].includes(methodLower)) {
    config.data = body;
  }

  try {
    const response = await axios.request<T>(config);
    return response;
  } catch (error) {
    // rethrow the error so callers can inspect axios error/response
    throw error;
  }
};

export default ApiHelper;