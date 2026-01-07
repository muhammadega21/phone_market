import register from '@/routes/register';
import { Link } from '@inertiajs/react';

const Login = () => {
    return (
        <div className="grid h-screen w-screen place-items-center">
            <fieldset className="fieldset w-sm rounded-box border border-base-300 bg-white p-4">
                <h1 className="mb-4 text-center text-xl font-bold">Login</h1>
                <label className="label">Email</label>
                <input type="email" className="input w-full" placeholder="Email" />

                <label className="label">Password</label>
                <input type="password" className="input w-full" placeholder="Password" />

                <button className="btn mt-2 btn-primary">Login</button>
                <p className="text-sm">
                    Belum punya akun?{' '}
                    <Link href={register.index.url()} className="text-sky-600 underline">
                        Daftar
                    </Link>
                </p>
            </fieldset>
        </div>
    );
};

export default Login;
