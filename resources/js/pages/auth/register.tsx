import login from '@/routes/login';
import { Link } from '@inertiajs/react';

const Register = () => {
    return (
        <div className="grid h-screen w-screen place-items-center">
            <fieldset className="fieldset w-sm rounded-box border border-base-300 bg-white p-4">
                <h1 className="mb-4 text-center text-xl font-bold">Register</h1>
                <label className="label">Nama</label>
                <input type="text" className="input w-full" placeholder="Nama" />

                <label className="label">Email</label>
                <input type="email" className="input w-full" placeholder="Email" />

                <label className="label">Password</label>
                <input type="password" className="input w-full" placeholder="Password" />

                <button className="btn mt-2 btn-primary">Daftar</button>
                <p className="text-sm">
                    Sudah punya akun?{' '}
                    <Link href={login.index.url()} className="text-sky-600 underline">
                        Login
                    </Link>
                </p>
            </fieldset>
        </div>
    );
};

export default Register;
