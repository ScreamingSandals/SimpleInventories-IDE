package org.screamingsandals.simpleinventories.ide.builder;

import lombok.AllArgsConstructor;

import java.util.Map;

@AllArgsConstructor
public class GroovyMapOptionsBuilder implements IGroovyLocalOptionsBuilder{
    private final Map<String, Object> map;

    @Override
    public void backItem(Map<String, Object> stack) {
        map.put("backItem", stack);
    }

    @Override
    public void pageBackItem(Map<String, Object> stack) {
        map.put("pageBackItem", stack);
    }

    @Override
    public void pageForwardItem(Map<String, Object> stack) {
        map.put("pageForwardItem", stack);
    }

    @Override
    public void cosmeticItem(Map<String, Object> stack) {
        map.put("cosmeticItem", stack);
    }

    @Override
    public void rows(int rows) {
        map.put("rows", rows);
    }

    @Override
    public void itemsOnRow(int itemsOnRow) {
        map.put("items_on_row", itemsOnRow);
    }

    @Override
    public void renderActualRows(int renderActualItems) {
        map.put("render_actual_rows", renderActualItems);
    }

    @Override
    public void renderOffset(int renderOffset) {
        map.put("render_offset", renderOffset);
    }

    @Override
    public void renderHeaderStart(int renderHeaderStart) {
        map.put("render_header_start", renderHeaderStart);
    }

    @Override
    public void renderFooterStart(int renderFooterStart) {
        map.put("render_footer_start", renderFooterStart);
    }

    @Override
    public void inventoryType(String inventoryType) {
        map.put("inventoryType", inventoryType);
    }
}