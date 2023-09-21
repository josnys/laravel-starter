import AdminLayout from '@/Layouts/AdminLayout';
import { Head, usePage } from '@inertiajs/react';
import DataTable from '@/Pages/Admin/Components/DataTable';
import DataTableItem from '../Components/DataTableItem';
import Dropdown from '@/Components/Dropdown';
import Icon from '@/Components/Icon';

export default function Index({ auth }) {
     const { info } = usePage().props;
     const users = info.users.data;

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
                                        return <tr key={`usr${i}`} className="hover:bg-slate-50">
                                             <DataTableItem>{related.person.code}</DataTableItem>
                                             <DataTableItem>{related.person.fullname}</DataTableItem>
                                             <DataTableItem>{username}</DataTableItem>
                                             <DataTableItem>{email}</DataTableItem>
                                             <DataTableItem>
                                                  <Dropdown>
                                                       <Dropdown.Trigger>
                                                            <span className="inline-flex rounded-md">
                                                                 <button
                                                                      type="button"
                                                                      className="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 transition duration-150 ease-in-out bg-white border border-transparent rounded-md text-slate-500 hover:text-slate-700 focus:outline-none"
                                                                 >
                                                                      Actions

                                                                      <svg
                                                                           className="ml-2 -mr-0.5 h-4 w-4"
                                                                           xmlns="http://www.w3.org/2000/svg"
                                                                           viewBox="0 0 20 20"
                                                                           fill="currentColor"
                                                                      >
                                                                           <path
                                                                                fillRule="evenodd"
                                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                                clipRule="evenodd"
                                                                           />
                                                                      </svg>
                                                                 </button>
                                                            </span>
                                                       </Dropdown.Trigger>

                                                       <Dropdown.Content>
                                                            <Dropdown.Link href={route('admin.user.edit', username)}>
                                                                 <Icon className={`mr-2 w-4 h-6`} name={'edit'} />Edit
                                                            </Dropdown.Link>
                                                            <Dropdown.Link href={route('admin.to.user')}>Change Password</Dropdown.Link>
                                                       </Dropdown.Content>
                                                  </Dropdown>
                                             </DataTableItem>
                                        </tr>
                                   })}
                              </DataTable>
                         </div>
                    </div>
               </section>
          </AdminLayout>
     );
}
