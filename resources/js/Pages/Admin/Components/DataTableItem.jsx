import React from "react";

export default ({ ...props }) => {
     return (<td className="px-2 py-1 transition ease-in-out border-b border-b-slate-200 text-slate-700 hover:bg-slate-50">
          {props.children}
     </td>);
}