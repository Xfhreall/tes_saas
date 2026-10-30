import { Form, Head, usePoll } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { hello } from '@/routes';
import { dispatch } from '@/routes/hello';

export default function Hello({ ping, logs }: { ping: string | boolean; logs: string[] }) {
    usePoll(3000, { only: ['ping', 'logs'] });

    return (
        <>
            <Head title="Hello" />
            <div className="flex flex-col gap-4 p-4">
                <div className="flex items-center justify-between">
                    <p className="text-sm text-muted-foreground">Redis ping: {String(ping)}</p>
                    <Form {...dispatch.form()}>
                        {({ processing }) => (
                            <Button type="submit" disabled={processing}>
                                Dispatch job
                            </Button>
                        )}
                    </Form>
                </div>
                <pre className="min-h-64 rounded-xl border p-4 font-mono text-sm">
                    {logs.length ? logs.join('\n') : 'Belum ada job jalan.'}
                </pre>
            </div>
        </>
    );
}

Hello.layout = {
    breadcrumbs: [{ title: 'Hello', href: hello() }],
};
