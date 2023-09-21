import AdminLayout from '@/Layouts/AdminLayout';
import { Head, usePage } from '@inertiajs/react';
import DataTable from '@/Pages/Admin/Components/DataTable';
import DataTableItem from '../Components/DataTableItem';

export default function Index({ auth }) {
     const { info } = usePage().props;
     const users = info.users.data;

     console.log(info);
     return (
          <AdminLayout
               user={auth.user}
               header={<h2 className="font-semibold leading-tight text-md text-slate-700">Admin / <span className="text-slate-500">Users</span></h2>}
          >
               <Head title="Dashboard" />

               <section className="w-full">
                    <div className="p-4 overflow-hidden bg-white">
                         <div className="w-full col-span-12">
                              <DataTable header={info.header} showNoData={users.length}>
                                   {users.map(({ id, username, email, related }, i) => {
                                        return <tr key={`usr${i}`}>
                                             <DataTableItem>{related.person.code}</DataTableItem>
                                             <DataTableItem>{related.person.fullname}</DataTableItem>
                                             <DataTableItem>{username}</DataTableItem>
                                             <DataTableItem>{email}</DataTableItem>
                                             <DataTableItem></DataTableItem>
                                        </tr>
                                   })}
                              </DataTable>
                         </div>
                    </div>
               </section>
          </AdminLayout>
     );
}
