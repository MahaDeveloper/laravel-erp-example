<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Client\Models\Module;

class ModuleController extends Controller
{
    public function getModules(Request $request)
    {
        $query = Module::query();
    
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('created_at', 'like', "%{$search}%");
        }
   
        if ($request->has('order')) {
            $columns = ['name', 'order','created_at'];
            $order = $request->order[0];
            $query->orderBy($columns[$order['column']], $order['dir']);
        } else {
           
            $query->orderBy('order', 'DESC');
        }
    
        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $total = $query->count();
    
        $data = $query->skip($start)->take($length)->get();
    
        // Add action buttons inline
        $data->transform(function ($item) {
            
            $item->order = '
                <div class="d-flex align-items-start justify-content-start">
                   
                    <i class="mdi mdi-arrow-up-bold order-up text-primary" data-id="' . $item->id . '" title="Move Up"></i>
                    <i class="mdi mdi-arrow-down-bold order-down text-primary ms-2" data-id="' . $item->id . '" title="Move Down"></i>
                   
                </div>';

            $item->action = '             
                <a href="#" class="edit-module text-primary" data-bs-toggle="offcanvas" data-bs-target="#editModuleModel" aria-controls="editModuleModel" data-id="' . $item->id . '" title="Edit">
                    <i class="mdi mdi-lead-pencil text-primary fs-5"></i>
                </a>
                <a href="#" class="delete-module text-danger ms-2" data-id="' . $item->id . '" title="Delete">
                    <i class="mdi mdi-delete fs-5"></i>
                </a>';  
        
            return $item;
        });
    
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
        
    }
    
    
    public function index()
    {
        return view('Client::modules.list');
    }


    public function storeModule(Request $request){

        $request->validate([
            'name' => 'required|unique:modules,name',
        ]);

        Module::create([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Module created successfully.']);
    }

    public function editModule($module_id)
    {
        $module = Module::find($module_id);

        return response()->json(['module' => $module]);
    }
    
    public function updateModule(Request $request, $module_id)
    {
        $request->validate([
            'name' => 'required|unique:modules,name,' . $module_id,
        ]);

        $module = Module::find($module_id);
      
        $module->update([
            'name' => $request->name,
        ]);

        return response()->json(['status' => 'success']);
    }
    

    public function delete($module_id){

        $module = Module::find($module_id);

        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $module->delete();

        return response()->json(['success' => 'Module deleted successfully']);
    }

    public function updateOrder(Request $request)
    {
        $currentModule = Module::find($request->current_id);
        $swapModule = Module::find($request->swap_id);

        $tempOrder = $currentModule->order;
        $currentModule->order = $swapModule->order;
        $swapModule->order = $tempOrder;

        $currentModule->save();
        $swapModule->save();

        return response()->json(['success' => 'Order changed successfully']);
    }


    
}
